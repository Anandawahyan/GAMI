<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, Order $review) {
        $rating = $request->rating;
        $komen = $request->komen;
        // dd($review->id);
        DB::table('reviews')->insert(['review_text'=>$komen, 'rating'=>$rating, 'order_id'=>$review->id, 'created_at'=>now(), 'updated_at'=>now()]);

        return redirect()->route('payment.show', $review->id);
    }
}
