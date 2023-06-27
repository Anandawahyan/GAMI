<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
     * @group CustomerBarang
	 * 
     * 
 */
class CustomerBarangController extends Controller
{
    
/**
     * Show items
     * 
     * Show the list of items that are retrieved by database
     * @authenticated
	 * @response {
     *      "status": 200,
     *      "success": true,
     *      "data": [{
     *          "id": 10,
     *          "price": 100000,
     *          "name": "Baju Baru",
     *          "image_url": "1234215asdasd.png"
     *      }]
     * }
	 *
	 */
    public function index() {

        if(Auth::check()) {
            $products = DB::table('items')->join('categories', 'categories.id', '=', 'items.category_id')->select('items.id','items.name','price', 'image_url', 'categories.name as category_name')->where('is_sold','=',0)->orderBy('created_at', 'desc')->limit(15)->get();
            return view('pages.customer.landingPage', ['products'=>$products]);
        } else {
            $products = DB::table('items')->join('categories', 'categories.id', '=', 'items.category_id')->select('items.id','items.name','price', 'image_url', 'categories.name as category_name')->where('is_sold','=',0)->orderBy('created_at', 'desc')->limit(15)->get();
            return view('pages.customer.landingPage', ['products'=>$products]);
        }
    }

    /**
     * Show items by id
     * 
     * Show the item information by id. it also returns the product recommendations related to that item.
     * @authenticated
	 * @response {
     *      "status": 200,
     *      "success": true,
     *      "data": {product: [{
     *          "id": 10,
     *          "price": 100000,
     *          "name": "Baju Baru",
     *          "image_url": "1234215asdasd.png"
     *      }]
     *          recommendedProduct: [{
     *          "id": 11,
     *          "price": 100000,
     *          "name": "Baju Merah",
     *          "image_url": "1234215asdasd.png"
     *      }]
     *      }
     * }
	 *
	 */
    public function show($id) {
        $product = DB::table('items')->join('categories', 'categories.id', '=', 'items.category_id')->join('colors', 'colors.id', '=', 'items.color_id')->select('items.id','items.name','price', 'image_url', 'categories.name as category_name', 'colors.name as color_name', 'description', 'condition', 'size', 'sex', 'region_of_origin')->where('items.id','=',$id)->get();
        $recommendedProducts = DB::table('items')->join('categories', 'categories.id', '=', 'items.category_id')->join('colors', 'colors.id', '=', 'items.color_id')->select('items.id','items.name','price', 'image_url', 'categories.name as category_name', 'colors.name as color_name', 'description', 'condition', 'size', 'sex')->where('items.id', '!=', $product[0]->id)
        ->where('items.category_id','!=', 8)
        ->where('items.is_sold','=',0)
        ->where(function ($query) use ($product) {
            $query->where('categories.name', 'LIKE', $product[0]->category_name)
                ->where('colors.name', 'LIKE', $product[0]->color_name);
        })->get();

        if(count($recommendedProducts) < 3) {
            $recommendedProducts = DB::table('items')->join('categories', 'categories.id', '=', 'items.category_id')->join('colors', 'colors.id', '=', 'items.color_id')->select('items.id','items.name','price', 'image_url', 'categories.name as category_name', 'colors.name as color_name', 'description', 'condition', 'size', 'sex')->where('items.id', '!=', $product[0]->id)
            ->where('items.category_id','!=', 8)
            ->where('items.is_sold','=',0)
            ->where(function ($query) use ($product) {
                $query->where('categories.name', 'LIKE', $product[0]->category_name)
                    ->orWhere('colors.name', 'LIKE', $product[0]->color_name);
            })->limit(4)->get();
        }

        return view('pages.customer.detailPesanan', ['product'=>$product[0], 'recommendedProducts'=>$recommendedProducts]);
    }

    /**
     * Show items for catalog
     * 
     * Show the items for catalog
     * @authenticated
	 * @response {
     *      "status": 200,
     *      "success": true,
     *      "data":  [{
     *          "id": 10,
     *          "price": 100000,
     *          "name": "Baju Baru",
     *          "image_url": "1234215asdasd.png"
     *      }]
     * }
	 *
	 */
    public function catalog_index(Request $request) {
        $input = $request->all();
        $categories = DB::table('categories')->where('id','!=', 8)->get();
        $colors = DB::table('colors')->get();
        $sizes = array('S','M','L','XL','XXL');
        $types = array('Laki-laki', 'Perempuan','Unisex');
        if($request->exists('name')) {
            $itemsArray = Item::join('categories', 'categories.id', '=', 'items.category_id')
                        ->join('colors', 'colors.id', '=', 'items.color_id')
                        ->select('items.id','items.name','price', 'image_url', 'categories.name as category_name', 'colors.name as color_name', 'description', 'condition', 'size', 'sex')
                        ->where('items.is_sold','=',0)
                        ->where('items.name', 'LIKE', '%' . $input['name'] . '%')
                        ->ignoreRequest(['perpage','size','sex','category_id','color_id'])
                        ->orderByDesc('id')->paginate(12,['*'],'page')->appends($input['name'])->toArray();
        } else {
            $itemsArray = Item::join('categories', 'categories.id', '=', 'items.category_id')
                        ->join('colors', 'colors.id', '=', 'items.color_id')
                        ->select('items.id','items.name','price', 'image_url', 'categories.name as category_name', 'colors.name as color_name', 'description', 'condition', 'size', 'sex')
                        ->where('items.is_sold','=',0)
                        ->ignoreRequest(['perpage'])->filter()
                        ->orderByDesc('id')->paginate(12,['*'],'page')->appends($input)->toArray();
        }

        // dd($input);


        return view('pages.customer.catalog', ['itemsArray'=>$itemsArray, 'categories'=>$categories, 'colors'=>$colors, 'inputs'=>$input, 'sizes'=>$sizes, 'types'=>$types]);
    }
}
