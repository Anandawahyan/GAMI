<?php

namespace App\Services\Midtrans;

use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use App\Models\Transaction;
use App\Models\Order;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $buyer = DB::table('users')->join('orders','orders.buyer_id','=','users.id')->select('users.name','users.email')->where('orders.id','=',$this->order->id)->get();
        $itemsList = DB::table('items')->join('transactions', 'transactions.item_id','=','items.id')->select('items.id','items.name','items.price')->where('transactions.order_id','=',$this->order->id)->get()->toArray();

        $items = array_map(function($item) {
            return [
                'id'=> $item->id,
                'price'=>$item->price,
                'quantity'=>1,
                'name'=>$item->name
            ];
        }, $itemsList);

        $params = [
            'transaction_details' => [
                'order_id' => $this->order->id,
                'gross_amount' => $this->order->total_amount + $this->order->ongkir
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $buyer[0]->name,
                'email' => $buyer[0]->email,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}