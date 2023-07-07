<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index() {
        if(Auth::user()->role == 'admin') {
            $activities = Activity::where('id_user','=',Auth::user()->id)->orderBy('created_at','desc')->get();
        } else {
            $activities = Activity::join('users','users.id','id_user')->select('activities.*','users.name as nama_user')->orderBy('activities.created_at','desc')->get();
        }

        return view('pages.admin.activity', ["activities"=>$activities,"type_menu"=>'']);
    }
}
