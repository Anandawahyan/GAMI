<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index() {
        $orders = DB::table('orders')
        ->select('orders.id as order_id', 'orders.order_date as date', 'users.name', 'users.address', 'status.id as status')
        ->join('users', 'users.id', '=', 'orders.buyer_id')
        ->join('status', 'status.id', '=', 'orders.status_id')
        ->get();

        return view('pages.admin.order',['type_menu'=>'order', 'orders'=>$orders]);
    }
    public function show($id) {
        $order = DB::table('orders')
        ->select('orders.id as order_id', 'orders.order_date as date', 'orders.ongkir', 'orders.total_amount', 'users.name', 'users.address', 'status.id as status', 'discounts.percentage as diskon')
        ->join('users', 'users.id', '=', 'orders.buyer_id')
        ->join('status', 'status.id', '=', 'orders.status_id')
        ->leftJoin('discounts', 'discounts.id', '=', 'orders.discount_id')
        ->where('orders.id','=',$id)
        ->get();

        $listOfItems = DB::table('items')
        ->select('items.name', 'items.price')
        ->join('transactions', 'transactions.item_id', '=', 'items.id')
        ->where('transactions.order_id', '=', $id)
        ->get();

        $subtotal = 0;

        foreach($listOfItems as $item) {
            $subtotal += $item->price;
        }

        return view('pages.admin.order-detail', ['type_menu'=>'','order'=>$order[0],'items'=>$listOfItems, 'subtotal'=>$subtotal]);
    }
}
