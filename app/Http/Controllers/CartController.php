<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request) {
        $cartItems = array();
        $totalPrice = 0;

        if($request->session()->has('cart_items')) {
            $cartItems = Item::whereIn('id', session('cart_items'))->get();
            $totalPrice = $cartItems->sum('price');
        } 

        return view('pages.customer.cart', ['cart_items'=>$cartItems, 'total_price'=>$totalPrice]);
    }
    public function store(Request $request, $id) {
        if($request->session()->has('cart_items')) {
            $dumpArray = session('cart_items');
            if(($key = array_search($id, $dumpArray)) !== false) {
                toastr()->error('Barang sudah ada di dalam keranjang');
                return redirect()->intended('/barang/' . $id);
            }
            array_push($dumpArray, $id);
            session(['cart_items'=>$dumpArray]);
        } else {
            session(['cart_items'=>[$id]]);
        }

        toastr('Barang dimasukkan ke keranjang');
        return redirect()->intended('/barang/' . $id);
    }

    public function delete(Request $request, $id) {
        $dumpArray = session('cart_items');
        if(($key = array_search($id, $dumpArray)) !== false) {
            unset($dumpArray[$key]);
        }
        $dumpArray = array_values($dumpArray);
        session(['cart_items'=>$dumpArray]);

        toastr('Barang dikeluarkan dari keranjang');
        return redirect()->route('cart.index');
    }

    public function getDiscounts() {
        $points = Auth::user()->points;

        $discounts = DB::table('discounts')->select('*')->where('is_active', '=', 1)
        ->where(function ($query) use ($points) {
            if($points > 0 && $points < 300) {
                $query->where('special','=',0)
                ->orWhere('id','=', 3);
            } elseif($points <= 0) {
                $query->where('special','=',0)
                ->orWhere('id','=', 2);
            } else {
                $query->where('special','=',0)
                ->orWhere('id','=', 4);
            }
        })->get();

        $response['data'] = $discounts;

        return response()->json($response);
    }
}
