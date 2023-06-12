<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startDate = Carbon::create(2023, 5, 15); // Start date: 15 May 2023
        $endDate = Carbon::now(); // End date: Current date and time

        $buyerIds = range(10, 20);
        $itemIds = range(20, 40);
        $statusId = 1;
        // Assuming status_id 1 represents a default status

        for ($i = 0; $i < 20; $i++) {
            $transaction = new Transaction();
            $transaction->item_id = $itemIds[rand(0, count($itemIds) - 1)];
            $transaction->buyer_id = $buyerIds[rand(0, count($buyerIds) - 1)];
            $transaction->discount_id = null;
            $transaction->transaction_date = $this->generateRandomDate($startDate, $endDate);
            $transaction->amount = rand(100, 10000) / 100; // Random decimal amount between 1.00 and 100.00
            $transaction->status_id = $statusId;
            $transaction->created_at = now();
            $transaction->updated_at = now();
            $transaction->save();
        }
    }

    private function generateRandomDate($startDate, $endDate)
    {
        $startTimestamp = $startDate->timestamp;
        $endTimestamp = $endDate->timestamp;

        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);

        return Carbon::createFromTimestamp($randomTimestamp);
    }
}
