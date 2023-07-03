<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\Alamat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\Midtrans\CreateSnapTokenService;

class PaymentController extends Controller
{
    public function index() {
        $user_id = Auth::user()->id;
        $orders = Order::join('status','status.id','=','orders.status_id')->select('orders.*','status.name as status')->where('buyer_id','=',$user_id)->where('status_id','!=',2)->get();
        // dd($orders);
        return view('pages.customer.orders', ['orders'=>$orders]);
    }

    public function show(Order $order) {
        // dd($order);
        $snapToken = $order->snap_token;
        $user = $order->user;
        $name = $user->name;
        $alamat = $order->alamat;
        $status = $order->status;
        $discount = $order->discount;

        // dd([$status, $discount]);

        $itemIds = Transaction::select('item_id')->where('order_id','=',$order->id)->get();
        $ids = array_map(function($item) {
            return $item['item_id'];
        }, $itemIds->toArray());

        $items = Item::find([$ids]);
        $totalPriceBeforeDiscount = $items->sum('price');
        // dd($totalPriceBeforeDiscount);

        if (is_null($snapToken)) {
            // If snap token is still NULL, generate snap token and save it to database

            $midtrans = new CreateSnapTokenService($order);
            $snapToken = $midtrans->getSnapToken();

            $order->snap_token = $snapToken;
            $order->save();
        }

        return view('pages.customer.invoices', ['snap_token'=>$snapToken, 'order'=>$order,'user_name'=>$name,'items'=>$items, 'alamat'=>$alamat, 'status'=>$status, 'discount'=>$discount, 'totalPriceBeforeDiscount'=>$totalPriceBeforeDiscount]);
    }

    public function store(Request $request) {
        $faker = \Faker\Factory::create();
        $m = new \Moment\Moment();

        $uid = $faker->uuid();
        $user_id = Auth::user()->id;
        $total_amount = $request->totalPrice;
        $ongkir = $request->ongkir;
        $status_id = 5;
        $diskon_id = $request->diskonId;
        $id_alamat = $request->alamat;

        $alamat = DB::table('alamat')->where('id','=',$id_alamat)->get();
        $est_arrival_date = $alamat[0]->shipping_time;

        $order = new Order();

        $order->id = $uid;
        $order->buyer_id = $user_id;
        $order->order_date = now();
        $order->total_amount = $total_amount;
        $order->ongkir = $ongkir;
        $order->status_id = $status_id;
        $order->discount_id = $diskon_id;
        $order->id_alamat = $id_alamat;
        $order->est_arrival_date = $m->addDays($est_arrival_date)->format('Y-m-d');

        for($i = 0; $i < count(session('cart_items')); $i++) {
            $item = Item::find(session('cart_items')[$i]);
            $item->is_sold = 1;

            $transaction = new Transaction();

            $transaction->item_id = session('cart_items')[$i];
            $transaction->order_id = $uid;

            $item->save();
            $transaction->save();
        }
     
        // dd($order);
        $order->save();
        Session::forget('cart_items');

        return redirect()->route('payment.show', $uid);
    }

    public function update_order_status(Request $request, Order $order) {
        // echo "berhasil";
        $order->status_id = $request->statusId;

        if($request->status_id == 2) {
            $itemIds = Transaction::select('item_id')->where('order_id','=',$order->id)->get();
            
            foreach($itemIds as $item) {
                $item = Item::find('id','=',$item->item_id);
                $item->is_sold = 0;

                $item->save();
            }
        }
        $order->save();

        return redirect()->route('payment.show', $order->id);
    }
}
