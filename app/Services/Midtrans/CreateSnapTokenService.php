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

        $params = [
            'transaction_details' => [
                'order_id' => $this->order->id,
                'gross_amount' => $this->order->total_amount + $this->order->ongkir
            ],
            'customer_details' => [
                'first_name' => $buyer[0]->name,
                'email' => $buyer[0]->email,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}