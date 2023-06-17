<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\Rupiah;

class Admin_Dashboard_Controller extends Controller
{
    public function index() {
        $m = new \Moment\Moment('');
        $m = $m->format('Y-m-d');

        $salesCount = Order::whereRaw('WEEK(order_date) = WEEK(?)', [$m])->count();
        $orders = Order::all();
        $this_week_revenue = convertToRupiah(Order::whereRaw('WEEK(order_date) = WEEK(?)', [$m])->sum('total_amount'));
        $total_products = Item::all()->count();
        $onGoingItems = Order::join('users','orders.buyer_id','=','users.id')->where('orders.status_id','<',4)->select('orders.id as id','users.name as name','orders.order_date as date','orders.status_id as status')->limit(5)->get();
        $confirmedProduct = 0;
        $declinedProduct = 0;
        $deliveringProduct = 0;
        $deliveredProduct = 0;
        $messages = Message::join('users','messages.user_id','=','users.id')->select("messages.message_title as title","messages.message_text as text","users.name as name")->limit(5)->get();

        foreach($orders as $order) {
            if($order->status_id == 1) {
                $confirmedProduct++;
            } elseif($order->status_id == 2) {
                $declinedProduct++;
            } elseif($order->status_id == 3) {
                $deliveringProduct++;
            } else {
                $deliveredProduct++;
            }
        }

        return view('pages.admin.dashboard-admin', 
        ['sales_count'=>$salesCount, 
        'type_menu'=>'dashboard', 
        'this_week_revenue'=>$this_week_revenue,
        'total_products'=>$total_products,
        'confirmed_products'=>$confirmedProduct,
        'declined_products'=>$declinedProduct,
        'delivering_products'=>$deliveringProduct,
        'delivered_products'=>$deliveredProduct,
        'onGoingItems'=>$onGoingItems,
        'messages'=>$messages
    ]);
    }

    public function getSalesForChart() {
        $salesByMonth = Order::select(DB::raw('MONTH(order_date) AS month_number'), DB::raw('SUM(total_amount) AS revenue'))
                ->whereYear('order_date', 2023)
                ->groupBy(DB::raw('MONTH(order_date)'))
                ->orderBy(DB::raw('MONTH(order_date)'))
                ->get();
        
        $salesMonthsRevenue = [0,0,0,0,0,0,0,0,0,0,0,0];

        foreach($salesByMonth as $sales) {
            $salesMonthsRevenue[$sales->month_number-1] = $sales->revenue;
        }

        $response['data'] = $salesMonthsRevenue;
        return response()->json($response);
    }
}
