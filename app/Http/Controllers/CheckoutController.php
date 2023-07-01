<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Item;

class CheckoutController extends Controller
{
    public function index() {
        $name = Auth::user()->name;
        $email = Auth::user()->email;

        $itemIds = session('checkout_info')['items'];
        $totalPrice =  session('checkout_info')['total_price'];
        $discountId = session('checkout_info')['discount_id'];
        $items = Item::select('id','name','price')->whereIn('id',$itemIds)->get();
        // echo $apiKey;

        $discount = DB::table('discounts')->where('id','=',$discountId)->get();
        
        $responseData = Cache::get('daftarKota');
        if(!$responseData) {
            $responseData = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY'),
                'Content-Type' => 'application/json',
            ])->get('https://api.rajaongkir.com/starter/city');

            $responseData = $responseData->json('rajaongkir')['results'];

            Cache::put('daftarKota', $responseData);
        }

        
        // $responseData = Http::withHeaders([
        //     'key' => env('RAJAONGKIR_API_KEY'),
        //     'Content-Type' => 'application/json',
        // ])->get('https://api.rajaongkir.com/starter/city');
        // $responseData = $responseData->json('rajaongkir')['results'];
        
        // dd($responseData);

        if(count($discount) > 0) {
            $discount = $discount[0];
        } else {
            $discount = false;
        }

        // dd(['name'=>$name, 'email'=>$email, 'discount'=>$discount, 'items'=>$items, 'total_price'=>$totalPrice]);

        return view('pages.customer.checkout-detail', ['name'=>$name, 'email'=>$email, 'discount'=>$discount, 'items'=>$items, 'total_price'=>$totalPrice, 'daftar_kota'=>$responseData]);
    }

    public function getAlamatUser() {
        $response['data'] = 0;

        $idUser = Auth::user()->id;
        $alamatUser = DB::table('alamat')->select('*')->where('user_id','=',$idUser)->get();

        if(count($alamatUser) > 0) {
            $response['data'] = $alamatUser;
            return response()->json($response);
        }

        return response()->json($response);
    }

    public function store(Request $request) {
        $items = session('cart_items');
        $totalPrice =  $request->totalPrice;
        $discountId = $request->discountId;

        session(['checkout_info'=>['items'=>$items, 'total_price'=>$totalPrice, 'discount_id'=>$discountId]]);
        return redirect()->route('checkout.index');
    }
}
