<?php

namespace App\Http\Controllers;

use App\Models\Message;
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

        $salesCount = Transaction::whereRaw('WEEK(transaction_date) = WEEK(?)', [$m])->count();
        $transactions = Transaction::all();
        $this_week_revenue = convertToRupiah(Transaction::whereRaw('WEEK(transaction_date) = WEEK(?)', [$m])->sum('amount'));
        $total_products = Item::all()->count();
        $onGoingItems = Transaction::join('users','transactions.buyer_id','=','users.id')->where('transactions.status_id','<',4)->select('transactions.id as id','users.name as name','transactions.transaction_date as date','transactions.status_id as status')->limit(5)->get();
        $confirmedProduct = 0;
        $declinedProduct = 0;
        $deliveringProduct = 0;
        $deliveredProduct = 0;
        $messages = Message::join('users','messages.user_id','=','users.id')->select("messages.message_title as title","messages.message_text as text","users.name as name")->limit(5)->get();

        foreach($transactions as $transaction) {
            if($transaction->status_id == 1) {
                $confirmedProduct++;
            } elseif($transaction->status_id == 2) {
                $declinedProduct++;
            } elseif($transaction->status_id == 3) {
                $deliveringProduct++;
            } else {
                $deliveredProduct++;
            }
        }

        return view('pages.admin.admin_dashboard', 
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
        $salesByMonth = Transaction::select(DB::raw('MONTH(transaction_date) AS month_number'), DB::raw('SUM(amount) AS revenue'))
                ->whereYear('transaction_date', 2022)
                ->groupBy(DB::raw('MONTH(transaction_date)'))
                ->orderBy(DB::raw('MONTH(transaction_date)'))
                ->get();
        
        $salesMonthsRevenue = [0,0,0,0,0,0,0,0,0,0,0,0];

        foreach($salesByMonth as $sales) {
            $salesMonthsRevenue[$sales->month_number-1] = $sales->revenue;
        }

        $response['data'] = $salesMonthsRevenue;
        return response()->json($response);
    }
}
