<?php

namespace App\Http\Controllers;

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

        $sales_yesterday = Transaction::whereRaw('DATE(transaction_date) = DATE(?)',[$m_yesterday])->sum('amount');
        $sales_prior_week = Transaction::whereRaw('WEEK(transaction_date) = WEEK(?)-1',[$m_yesterday])->sum('amount');
        $sales_prior_month = Transaction::whereRaw('MONTH(transaction_date) = MONTH(?)-1',[$m_yesterday])->sum('amount');
        $sales_prior_year = Transaction::whereRaw('YEAR(transaction_date) = YEAR(?)-1',[$m_yesterday])->sum('amount');

        $sales_per_period['today'] = Transaction::whereRaw('DATE(transaction_date) = DATE(?)',[$m_today])->sum('amount');
        $sales_per_period['week'] = Transaction::whereRaw('WEEK(transaction_date) = WEEK(?)',[$m_today])->sum('amount');
        $sales_per_period['month'] = Transaction::whereRaw('MONTH(transaction_date) = MONTH(?)',[$m_today])->sum('amount');
        $sales_per_period['year'] = Transaction::whereRaw('YEAR(transaction_date) = YEAR(?)',[$m_today])->sum('amount');

        $sales_per_period_percentage['today'] = $this->get_percentage($sales_per_period['today'], $sales_yesterday);
        $sales_per_period_percentage['week'] = $this->get_percentage($sales_per_period['week'], $sales_prior_week);
        $sales_per_period_percentage['month'] = $this->get_percentage($sales_per_period['month'], $sales_prior_month);
        $sales_per_period_percentage['year'] = $this->get_percentage($sales_per_period['year'], $sales_prior_year);

        $totalSales = Transaction::sum('amount');
        $transactionCount = Transaction::count();
        $averageTransactionValue = convertToRupiah($totalSales/$transactionCount);
        $ratingData = DB::table('reviews')->select('rating')->get();

        $satisfactionScore = $this->calculateCustomerSatisfaction($ratingData);


        return view('pages.dashboard-general-dashboard',
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

    public function get_chart_contents() {
        $m = new \Moment\Moment('');
        $m = $m->format('Y-m-d');

        $sales_by_chart_content = DB::table('transactions')
        ->select(DB::raw('WEEK(transaction_date) AS week_start_date'), DB::raw('SUM(amount) AS total_amount'))
        ->whereRaw('MONTH(transaction_date) = MONTH(?)',[$m])
        ->groupBy('week_start_date')
        ->orderBy('week_start_date')
        ->get();

        $categories_and_colors_per_category = $this->get_colors_per_category();

        $men_women_demographic = DB::table('users')->join('transactions', 'users.id', '=', 'transactions.buyer_id')
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
        $currentMonthBuyers = Transaction::whereMonth('transaction_date', Carbon::now()->month)
            ->whereYear('transaction_date', Carbon::now()->year)
            ->distinct('buyer_id')
            ->pluck('buyer_id')
            ->toArray();

        // Get the distinct buyer_ids for the previous month
        $previousMonthBuyers = Transaction::whereMonth('transaction_date', Carbon::now()->subMonth()->month)
            ->whereYear('transaction_date', Carbon::now()->subMonth()->year)
            ->distinct('buyer_id')
            ->pluck('buyer_id')
            ->toArray();

        $twoMonthsAgoBuyers = Transaction::whereMonth('transaction_date', Carbon::now()->subMonths(2)->month)
        ->whereYear('transaction_date', Carbon::now()->subMonths(2)->year)
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
        $results = DB::table('transactions')
        ->join('users', 'users.id', '=', 'transactions.buyer_id')
        ->where('users.sex', '=', $sex)
        ->selectRaw('
            CASE
                WHEN TIMESTAMPDIFF(YEAR, users.birth_date, CURDATE()) BETWEEN 18 AND 24 THEN "18-24"
                WHEN TIMESTAMPDIFF(YEAR, users.birth_date, CURDATE()) BETWEEN 25 AND 34 THEN "25-34"
                ELSE "35 and older"
            END AS age_group,
            COUNT(DISTINCT transactions.buyer_id) AS customer_count
        ')
        ->groupBy('age_group')
        ->get();

        return $results;
                
    }

}
