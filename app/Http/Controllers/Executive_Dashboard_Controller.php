<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class Executive_Dashboard_Controller extends Controller
{

    public function index() {
        $m = new \Moment\Moment('');
        $m_today = $m->format('Y-m-d');
        $m_yesterday = $m->subtractDays(1)->format('Y-m-d');

        $sales_yesterday = Order::whereRaw('DATE(order_date) = DATE(?)',[$m_yesterday])->sum('total_amount');
        $sales_prior_week = Order::whereRaw('WEEK(order_date) = WEEK(?)-1',[$m_yesterday])->sum('total_amount');
        $sales_prior_month = Order::whereRaw('MONTH(order_date) = MONTH(?)-1',[$m_yesterday])->sum('total_amount');
        $sales_prior_year = Order::whereRaw('YEAR(order_date) = YEAR(?)-1',[$m_yesterday])->sum('total_amount');

        $sales_per_period['today'] = Order::whereRaw('DATE(order_date) = DATE(?)',[$m_today])->sum('total_amount');
        $sales_per_period['week'] = Order::whereRaw('WEEK(order_date) = WEEK(?)',[$m_today])->sum('total_amount');
        $sales_per_period['month'] = Order::whereRaw('MONTH(order_date) = MONTH(?)',[$m_today])->sum('total_amount');
        $sales_per_period['year'] = Order::whereRaw('YEAR(order_date) = YEAR(?)',[$m_today])->sum('total_amount');

        $sales_per_period_percentage['today'] = $this->get_percentage($sales_per_period['today'], $sales_yesterday);
        $sales_per_period_percentage['week'] = $this->get_percentage($sales_per_period['week'], $sales_prior_week);
        $sales_per_period_percentage['month'] = $this->get_percentage($sales_per_period['month'], $sales_prior_month);
        $sales_per_period_percentage['year'] = $this->get_percentage($sales_per_period['year'], $sales_prior_year);

        $totalSales = Order::sum('total_amount');
        $transactionCount = Order::count() == 0 ? 1 : Order::count();
        $averageTransactionValue = convertToRupiah($totalSales/$transactionCount);
        $ratingData = DB::table('reviews')->select('rating')->get();

        $satisfactionScore = $this->calculateCustomerSatisfaction($ratingData);


        return view('pages.admin.dashboard-executive',
        [
            'retention_rate'=>$this->calculateRetentionRate(),
            'sales_per_period_percentage'=>$sales_per_period_percentage,
            'sales_per_period'=>$sales_per_period,
            'avg_trans_value'=>$averageTransactionValue,
            'satisfaction_score'=>$satisfactionScore,
            'total_sales'=>convertToRupiah($totalSales),
            'type_menu'=>'dashboard',
        ]);
    }

    function calculateCustomerSatisfaction($data)
    {
        // Prepare the payload for the OpenAI API
        $payload = [
            'model' => 'text-davinci-001',
            'prompt' => 'calculate the customer satisfaction score based on this data ' . json_encode($data) . ', the customer satisfaction value is(output a number only no periodt)  :',
            'temperature' => 0,
            'max_tokens' => 4,
            'top_p' => 1,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ];

        // Make a POST request to the OpenAI API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer'.' '.env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/completions', $payload);

        // Parse the response and extract the customer satisfaction score
        $satisfactionScore = $response->json('choices')[0]['text'];
        return $satisfactionScore;
    }

    public function get_marketing_analysis()
    {
        $transaction_data = $this->getTransactionData();
        $stock_data = $this->getStockData();
        $payload = [
            'model' => 'text-davinci-003',
            'prompt' => $transaction_data.'based on this data, can you give me a marketing analysis like what would be the best selling items based on demographics data. Focus on like what gender should i approach? what age should i approach? make it simple and ONLY use 1 paragraph. At the end give me a suggestion on what should i do, IF in my inventory data is like this :\n'.$stock_data,
            'temperature' => 0.05,
            'max_tokens' => 256,
            'top_p' => 1,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ];

        $promise = Http::async()->withHeaders([
            'Authorization' => 'Bearer'.' '.env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/completions', $payload)->then(function ($response) {
            return $response;
        });;
    }

    // public function get_rfm_analysis() {
    //     $rfmScores = DB::table('orders')
    //         ->select('buyer_id', DB::raw('DATEDIFF(MAX(order_date), CURDATE()) AS recency'), DB::raw('COUNT(*) AS frequency'), DB::raw('SUM(total_amount) AS monetary_value'))
    //         ->groupBy('buyer_id')
    //         ->get();
        
    //         $header = 'buyer_id,recency,frequency,monetary_value';

    //         $rows = $rfmScores->map(function ($result) {
    //             return implode(',', [
    //                 $result->buyer_id,
    //                 $result->recency,
    //                 $result->frequency,
    //                 $result->monetary_value,
    //             ]);
    //         })->join("\n");
    
    //         $output = $header . "\n" . $rows;

    //         $payload = [
    //             'model' => 'text-davinci-003',
    //             'prompt' => $output . 'based on this data, can you give me an analysis like what can i do  based on demographics data. Focus on like what would be the best option for me to leverage my business, make it simple and ONLY use 1 paragraph.(the monetary_value is in rupiah)',
    //             'temperature' => 0.01,
    //             'max_tokens' => 256,
    //             'top_p' => 1,
    //             'frequency_penalty' => 0,
    //             'presence_penalty' => 0,
    //         ];
    
    //         $response = Http::async()->withHeaders([
    //             'Authorization' => 'Bearer'.' '.env('OPENAI_API_KEY'),
    //             'Content-Type' => 'application/json',
    //         ])->post('https://api.openai.com/v1/completions', $payload);
    
    //         return $response;
    // }

    // public function get_review_analysis() {
    //         $reviews = DB::table('reviews')->select('review_text')->get();

    //         $payload = [
    //             'model' => 'text-davinci-001',
    //             'prompt' => json_encode($reviews) . 'write a conclusion about this review text data, i want to know what is my customers thinking about my products, Focus on what should i improve based on it. make it simple and ONLY use 1 paragraph.',
    //             'temperature' => 0.01,
    //             'max_tokens' => 256,
    //             'top_p' => 1,
    //             'frequency_penalty' => 0,
    //             'presence_penalty' => 0,
    //         ];
    
    //         $response = Http::async()->withHeaders([
    //             'Authorization' => 'Bearer'.' '.env('OPENAI_API_KEY'),
    //             'Content-Type' => 'application/json',
    //         ])->post('https://api.openai.com/v1/completions', $payload);
    
    //         return $response;
    // }

    function getTransactionData() {
        $result = DB::table('users')
        ->join('orders', 'users.id', '=', 'orders.buyer_id')
        ->join('transactions','orders.id', '=', 'transactions.id')
        ->join('items', 'transactions.item_id', '=', 'items.id')
        ->join('colors', 'colors.id', '=', 'items.color_id')
        ->join('categories', 'categories.id', '=', 'items.category_id')
        ->select('users.sex as user_sex', 'colors.name as color', 'categories.name as category_name', 'transactions.amount as transaction_amount', 'items.sex as item_for', 'users.birth_date as user_birth_date')
        ->get();

        $header = 'user_sex,name,color,category_name,transaction_amount,item_sex,user_birth_date';

        // Create the data rows
        $rows = $result->map(function ($result) {
            return implode(',', [
                $result->user_sex,
                $result->color,
                $result->category_name,
                $result->transaction_amount,
                $result->item_for,
                $result->user_birth_date,
            ]);
        })->join("\n");

        $output = $header . "\n" . $rows;
        return $output;
    }

    public function getStockData() {
        $category_stock = DB::table('items')->join('categories', 'items.category_id', '=', 'categories.id')
        ->select('categories.name as category_name', DB::raw('COUNT(*) as stock'))
        ->where('items.is_sold','=',0)
        ->groupBy('categories.name')
        ->get();

        $item_sex_stock = DB::table('items')->select('sex as item_sex_name', DB::raw('COUNT(*) as stock'))
        ->where('is_sold', 0)
        ->groupBy('sex')
        ->get();
    

        $header_category = 'category_name, stock';
        $header_item_sex = 'category_name, stock';

        // Create the data rows
        $category_rows = $category_stock->map(function ($result) {
            return implode(',', [
                $result->category_name,
                $result->stock
            ]);
        })->join("\n");

        $item_sex_rows = $item_sex_stock->map(function ($result) {
            return implode(',', [
                $result->item_sex_name,
                $result->stock
            ]);
        })->join("\n");

        $output = $header_category . "\n" . $category_rows . "\n and the item sex type data\n" . $header_item_sex . "\n" . $item_sex_rows;
        return $output;
    }

    public function get_chart_contents() {
        $m = new \Moment\Moment('');
        $m = $m->format('Y-m-d');

        $sales_by_chart_content = DB::table('orders')
        ->select(DB::raw('WEEK(order_date) AS week_start_date'), DB::raw('SUM(total_amount) AS total_amount'))
        ->whereRaw('MONTH(order_date) = MONTH(?)',[$m])
        ->groupBy('week_start_date')
        ->orderBy('week_start_date')
        ->get();

        $categories_and_colors_per_category = $this->get_colors_per_category();

        $men_women_demographic = DB::table('users')->join('orders', 'users.id', '=', 'orders.buyer_id')
        ->select('users.sex as JENIS KELAMIN', DB::raw('COUNT(*) as JUMLAH'))
        ->groupBy('users.sex')
        ->get();

        $response['data']['salesByChartContent'] = $sales_by_chart_content;
        $response['data']['categories'] = $categories_and_colors_per_category['categories'];
        $response['data']['topSellingCategoriesColorsChartContent'] = $categories_and_colors_per_category['array_of_result'];
        $response['data']['customerRetentionRateData'] = $this->calculateRetentionRate();
        $response['data']['menWomenDemographicData'] = $men_women_demographic;
        $response['data']['ageGroupMale'] = $this->get_age_group_differsBy_sex('Laki-laki');
        $response['data']['ageGroupFemale'] = $this->get_age_group_differsBy_sex('Perempuan');
        $response['data']['RFMGroupingCustomers'] = $this->get_spending_segmentation();
        $response['data']['totalSpendingCategoryData'] = $this->get_total_spending_segmentation();
        return response()->json($response);
    }

    function get_percentage($selectedSales, $accumulator) {
        if($accumulator == 0) {
            return 100;
        }

        $result = (($selectedSales - $accumulator)/$accumulator)*100;
        return $result;
    }

    public function calculateRetentionRate()
    {
        // Get the current month and previous month
        $currentMonth = Carbon::now()->format('Y-m');
        $previousMonth = Carbon::now()->subMonth()->format('Y-m');
        $retentionRatePreviousPeriod = 0;
        $retentionRateThisPeriod = 0;

        // Get the distinct buyer_ids for the current month
        $currentMonthBuyers = Order::whereMonth('order_date', Carbon::now()->month)
            ->whereYear('order_date', Carbon::now()->year)
            ->distinct('buyer_id')
            ->pluck('buyer_id')
            ->toArray();

        // Get the distinct buyer_ids for the previous month
        $previousMonthBuyers = Order::whereMonth('order_date', Carbon::now()->subMonth()->month)
            ->whereYear('order_date', Carbon::now()->subMonth()->year)
            ->distinct('buyer_id')
            ->pluck('buyer_id')
            ->toArray();

        $twoMonthsAgoBuyers = Order::whereMonth('order_date', Carbon::now()->subMonths(2)->month)
        ->whereYear('order_date', Carbon::now()->subMonths(2)->year)
        ->distinct('buyer_id')
        ->pluck('buyer_id')
        ->toArray();

        // Calculate the retention rate
        if(count($currentMonthBuyers) != 0 && count($previousMonthBuyers) != 0) {
            $retentionRateThisPeriod = count(array_intersect($currentMonthBuyers, $previousMonthBuyers)) / count($previousMonthBuyers) * 100;
        }

        if(count($twoMonthsAgoBuyers) != 0 && count($previousMonthBuyers) != 0) {
            $retentionRatePreviousPeriod = count(array_intersect($previousMonthBuyers, $twoMonthsAgoBuyers)) / count($twoMonthsAgoBuyers) * 100;
        }

        return [$retentionRateThisPeriod, $retentionRatePreviousPeriod];
    }

    function get_colors_per_category() {
        $categories = DB::table('categories')
        ->join('items', 'categories.id', '=', 'items.category_id')
        ->join('transactions', 'items.id', '=', 'transactions.item_id')
        ->select('categories.name', DB::raw('COUNT(*) as qty'))
        ->groupBy('categories.name')
        ->orderByDesc('qty')
        ->limit(5)
        ->get();

        $colors = DB::table('colors')->select('name')->get();

        $array_result = [];
        foreach ($colors as $color) {
            $array_temp = [];
            foreach ($categories as $category) {
                $categoryName = $category->name;
                $count = DB::table('transactions')
                    ->join('items', 'transactions.item_id', '=', 'items.id')
                    ->join('categories', 'categories.id', '=', 'items.category_id')
                    ->join('colors', 'colors.id', '=', 'items.color_id')
                    ->whereRaw('categories.name = ?', [$categoryName])
                    ->whereRaw('colors.name = ?', [$color->name])
                    ->count();
                array_push($array_temp, $count);
            }
            array_push($array_result, ['color' => $color->name, 'array_per_category' => $array_temp]);
        }

        return ['array_of_result'=>$array_result, 'categories'=>$categories];
                
    }

    function get_age_group_differsBy_sex($sex) {
        $results = DB::table('orders')
        ->join('users', 'users.id', '=', 'orders.buyer_id')
        ->where('users.sex', '=', $sex)
        ->selectRaw('
            CASE
                WHEN TIMESTAMPDIFF(YEAR, users.birth_date, CURDATE()) BETWEEN 18 AND 24 THEN "18-24"
                WHEN TIMESTAMPDIFF(YEAR, users.birth_date, CURDATE()) BETWEEN 25 AND 34 THEN "25-34"
                ELSE "35 and older"
            END AS age_group,
            COUNT(DISTINCT orders.buyer_id) AS customer_count
        ')
        ->groupBy('age_group')
        ->get();

        return $results;
                
    }

    function get_spending_segmentation() {
        
        $rfmScores = DB::table('orders')
            ->select('buyer_id', DB::raw('DATEDIFF(MAX(order_date), CURDATE()) AS recency'), DB::raw('COUNT(*) AS frequency'), DB::raw('SUM(total_amount) AS monetary_value'))
            ->groupBy('buyer_id')
            ->get();

        // Group the RFM scores into segments
        $customerSegments = $rfmScores->groupBy(function ($rfm) {
            if ($rfm->recency >= -30 && $rfm->frequency >= 5 && $rfm->monetary_value >= 150000) {
                return 'High-Value Customers';
            }  elseif ($rfm->recency < -30 && $rfm->frequency >= 5 && $rfm->monetary_value > 150000) {
                return 'Loyal Customers';
            } elseif ($rfm->recency < -30 && $rfm->frequency < 5 && $rfm->monetary_value >= 300000) {
                return 'High-Spending Customers';
            } elseif ($rfm->recency > -10 && $rfm->frequency < 5 && $rfm->monetary_value < 150000) {
                return 'Recent Customers';
            } else {
                return 'Standard Customers';
            }
        });

        // Retrieve the customer counts per category
        $customerCounts = $customerSegments->map(function ($segment) {
            return $segment->count();
        });

        $result = $customerSegments->mapWithKeys(function ($segment, $key) {
            return [$key => $segment->count()];
        })->all();        

        return $result;
    }

    function get_total_spending_segmentation() {
        
        $result = DB::table(function ($subquery) {
            $subquery->select('u.id as user_id', 'u.name as user_name', DB::raw('SUM(o.total_amount) as total_spending'))
                ->from('users as u')
                ->join('orders as o', 'u.id', '=', 'o.buyer_id')
                ->groupBy('u.id', 'u.name');
        }, 'subquery')
            ->selectRaw('
                CASE 
                    WHEN total_spending <= 120000 THEN "Low Spender"
                    WHEN total_spending > 120000 AND total_spending <= 500000 THEN "Moderate Spender"
                    WHEN total_spending > 500000 THEN "High Spender"
                END AS spending_category,
                COUNT(*) AS customer_count'
            )
            ->groupBy('spending_category')
            ->get();   

        return $result;
    }

}
