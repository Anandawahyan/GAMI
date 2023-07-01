<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlamatController extends Controller
{
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

    public function storeAlamatUser(Request $request) {
        $user_id = Auth::user()->id;
        $alamat = $request->alamatBaru;
        $id_kota = $request->kotaBaru;
        $id_toko = 501;
        
        $responseData = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.rajaongkir.com/starter/cost',
        ['origin'=>$id_toko, 'destination'=>$id_kota, 'weight'=>1700, 'courier'=>'jne']);

        $ongkir = $responseData->json('rajaongkir')['results'][0]['costs'][0]['cost'][0]['value'];


        $insertedId = DB::table('alamat')->insertGetId([
            'alamat_rumah'=>$alamat,
            'id_kota'=>$id_kota,
            'ongkir'=>$ongkir,
            'user_id'=>$user_id,
            'created_at'=>now(),
            'updated_at'=>now()
        ]);

        // $alamats = DB::table('alamat')

        $response['data'] = ['id'=>$insertedId, 'alamat_rumah'=>$alamat,'ongkir'=>$ongkir];


        return response()->json($response);
    }

    
}
