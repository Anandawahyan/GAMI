<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $helpSentences = [
            "I'm having trouble adding items to my cart. Can someone assist me?",
            "How can I track my order status? I need some help with that.",
            "I'm unable to proceed with the payment. Any guidance would be appreciated.",
            "Can someone help me with the return process? I need to initiate a return.",
            "I have a question about the product specifications. Where can I find more information?"
        ];
        
        

        for($i=0; $i < count($helpSentences); $i++) {
            DB::table('messages')->insert(['message_text'=>$helpSentences[$i],'user_id'=>$i+1]);
        }


        // $statusId = 5;
        // $itemIds = range(1, 13);
        // $buyerIds = range(1, 20);
        
        // // Get the start and end dates for the transaction date range
        // $startDate = Carbon::create(2022, 8, 13, 0, 0, 0);
        // $endDate = Carbon::create(2022, 8, 19, 23, 59, 59);
        // $transactionDate30Percent = Carbon::create(2022, 8, 17, 0, 0, 0);
        
        // for ($i = 0; $i < 13; $i++) {
        //     $itemId = $itemIds[$i];
        //     $buyerId = $buyerIds[array_rand($buyerIds)];
        //     $discountId = 1; // Always set discount_id to 1
            
        //     $transactionDate = $startDate->copy()->addSeconds(mt_rand(0, $endDate->timestamp - $startDate->timestamp));
            
        //     if ($i < 4) {
        //         $transactionDate = $transactionDate30Percent;
        //     }
            
        //     $item = DB::table('items')->where('id', $itemId)->first();
        //     $amount = $item->price;
            
        //     $transaction = [
        //         'item_id' => $itemId,
        //         'buyer_id' => $buyerId,
        //         'discount_id' => $discountId,
        //         'transaction_date' => $transactionDate,
        //         'amount' => $amount,
        //         'status_id' => $statusId,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
            
        //     DB::table('transactions')->insert($transaction);
        }
    }

