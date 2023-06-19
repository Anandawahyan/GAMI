<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index($id) {
        $messages = Message::join('users','messages.user_id','=','users.id')->select("messages.message_title as title","messages.message_text as text","users.name as name","messages.created_at as created_at","messages.id as message_id")->where('messages.is_solved','=',0)->where('users.role','=','customer')->orderBy('created_at', 'asc')->get();
        
        $messageSpesific = Message::join('users','messages.user_id','=','users.id')->select("messages.message_title as title","messages.message_text as text","users.name as name","messages.created_at as created_at","messages.id as message_id")->where('messages.is_solved','=',0)->where('users.role','=','customer')->where('messages.id','=', $id)->orderBy('created_at')->get();
        $replies = Message::join('users','messages.user_id','=','users.id')->select("messages.message_title as title","messages.message_text as text","users.name as name","messages.created_at as created_at","messages.id as message_id","users.role as role")->where('messages.message_reference_id','=', $id)->orderBy('created_at', 'asc')->get();

        return view('pages.admin.tickets',['type_menu'=>'message','messages'=>$messages, 'messageSpesific'=>$messageSpesific, 'replies'=>$replies]);
    }
}
