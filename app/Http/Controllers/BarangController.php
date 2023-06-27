<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
     * @group Barang
	 * 
     * 
 */
class BarangController extends Controller
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
    public function index()
    {
        $items = Item::join('categories', 'categories.id', '=', 'items.category_id')
        ->join('colors', 'colors.id', '=', 'items.color_id')
        ->select('items.id','items.name', 'items.description', 'items.price', 'items.image_url', 'items.condition', 'items.size', 'items.region_of_origin', 'items.sex', 'categories.name AS category_name', 'colors.name AS color_name', 'items.is_sold')
        ->where('items.is_deleted','=',0)
        ->get();

        return view('pages.admin.barang', ['items'=>$items, 'type_menu'=>'barang']);
    }

    /**
	 * Show items on recycle bin
     * 
     * show items that are being thrown to trash
     * 
     * @response {
     *      "status": 200,
     *      "success": true
     * }
	 *
	 */
    public function sampah_index() {
        $items = Item::join('categories', 'categories.id', '=', 'items.category_id')
        ->join('colors', 'colors.id', '=', 'items.color_id')
        ->select('items.id','items.name', 'items.description', 'items.price', 'items.image_url', 'items.condition', 'items.size', 'items.region_of_origin', 'items.sex', 'categories.name AS category_name', 'colors.name AS color_name', 'items.is_sold')
        ->where('items.is_deleted','=',1)
        ->get();

        return view('pages.admin.barang-sampah', ['items'=>$items, 'type_menu'=>'barang']);
    }

    /**
	 * Show create item forms
     * 
     * Show create item forms
	 *
     * @response {
     *      "status": 200,
     *      "success": true
     * }
	 */
    public function create()
    {
        $categories = DB::table('categories')->get();
        $colors = DB::table('colors')->get();
        
        return view('pages.admin.barang-create',["type_menu"=>'barang', 'categories'=>$categories, 'colors'=>$colors]);
    }

    /**
	 * Create Item
     * 
     * Add item to database
     * 
     * @bodyParam image file required
     * @bodyParam name string required
     * @bodyParam description name required
     * @bodyParam category integer required
     * ID of category
     * @bodyParam color integer required
     * ID of color
     * @bodyParam condition string required
     * @bodyParam size string required
     * @bodyParam sex string required
     * Between Laki-laki, Perempuan, Unisex
     * @bodyParam price integer required
     * 
     * @authenticated
	 * @response {
     *      "status": 200,
     *      "success": true,
     * }
	 *
	 */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'     => 'required|min:5',
            'description'   => 'required|min:10',
            'category'   => 'required',
            'color'   => 'required',
            'condition'   => 'required',
            'price'   => 'required',
            'sex' => 'required',
            'size' => 'required',
            'region_of_origin' => 'required'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/img/itemImages', $image->hashName());

        Item::create([
            'image_url'=> $image->hashName(),
            'name'     => $request->name,
            'description'   => $request->description,
            'category_id'   => $request->category,
            'color_id'   => $request->color,
            'condition'   => $request->condition,
            'price'   => $request->price,
            'sex' => $request->sex,
            'size' => $request->size,
            'region_of_origin' => $request->region_of_origin,
            'is_sold'=> 0
        ]);

        toastr()->success('Barang berhasil dimasukkan');
        return redirect()->route('barang.index');
    }

     /**
     * Get item
     *
     * Get item by it's unique ID.
     *
     * @pathParam barang integer required
     * The ID of the item to retrieve. Example: 10
     *
     * @response {
     *      "status": 200,
     *      "success": true,
     *      "data": {
     *          "id": 10,
     *          "price": 100000,
     *          "name": "Baju Bola Neymar"
     *      }
     * }
     */
    public function show($id)
    {
        $barang = DB::table('items')
        ->join('categories', 'items.category_id', '=', 'categories.id')
        ->join('colors', 'items.color_id', '=', 'colors.id')
        ->select('items.*', 'categories.name as category', 'colors.name as color')
        ->where('items.id','=',$id)
        ->get();;

        return view('pages.admin.barang-detail', ['type_menu'=>'barang', 'barang'=>$barang[0]]);
    }

    /**
    * Show edit item forms
    * 
    * @pathParam barang integer required
    * The ID of the item to retrieve. Example: 10
    * 
     * @response {
     *      "status": 200,
     *      "success": true,
     *      "data": {
     *          "id": 10,
     *          "price": 100000,
     *          "name": "Baju Bola Neymar"
     *      }
     * }
    */
    public function edit(Item $barang)
    {
        $categories = DB::table('categories')->get();
        $colors = DB::table('colors')->get();


        $barang = DB::table('items')
        ->join('categories', 'items.category_id', '=', 'categories.id')
        ->join('colors', 'items.color_id', '=', 'colors.id')
        ->select('items.*', 'categories.name as category', 'colors.name as color')
        ->where('items.id','=',$barang->id)
        ->get();
        
        return view('pages.admin.barang-edit', ['type_menu'=>'barang', 'barang'=>$barang[0], 'categories'=>$categories, 'colors'=>$colors]);
    }

    /**
	 * Update item to database
     * 
     * Update desired item with new value and store it to database
     * 
     * @bodyParam image file optional
     * @bodyParam name string required
     * @bodyParam description name required
     * @bodyParam category integer required
     * ID of category
     * @bodyParam color integer required
     * ID of color
     * @bodyParam condition string required
     * @bodyParam size string required
     * @bodyParam sex string required
     * Between Laki-laki, Perempuan, Unisex
     * @bodyParam price integer required
     * 
     * @authenticated
	 * @response {
     *      "status": 200,
     *      "success": true,
     * }
	 *
	 */
    public function update(Request $request, Item $barang)
    {
        echo '<p>'.$barang.'</p>';
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'     => 'required|min:5',
            'description'   => 'required|min:10',
            'category'   => 'required',
            'color'   => 'required',
            'condition'   => 'required',
            'price'   => 'required',
            'sex' => 'required',
            'size' => 'required',
            'region_of_origin' => 'required'
        ]);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/img/itemImages', $image->hashName());

            //delete old image
            Storage::delete('public/img/itemImages'.$barang->image_url);

            //update barang with new image
            $barang->update([
                'image_url'     => $image->hashName(),
                'name'     => $request->name,
                'description'   => $request->description,
                'category_id'   => $request->category,
                'color_id'   => $request->color,
                'condition'   => $request->condition,
                'price'   => $request->price,
                'sex' => $request->sex,
                'size' => $request->size,
                'region_of_origin' => $request->region_of_origin,
            ]);

        } else {
          //update post without image
            $barang->update([
                'name'     => $request->name,
                'description'   => $request->description,
                'category_id'   => $request->category,
                'color_id'   => $request->color,
                'condition'   => $request->condition,
                'price'   => $request->price,
                'sex' => $request->sex,
                'size' => $request->size,
                'region_of_origin' => $request->region_of_origin,
            ]);
        }

        toastr()->success('Barang berhasil diedit');
        return redirect()->route('barang.index');
    }

    /**
	 * Send item to trash bin
     * 
     * Send item to trash bin by changing the is_deleted property to true
     * 
     * @pathParam barang integer required
     * ID of the item to put into trash bin
     * 
     * @authenticated
	 * @response {
     *      "status": 200,
     *      "success": true
     * }
	 */
    public function to_trash(Item $barang)
    {
        $barang->update([
            'is_deleted'=>1
        ]);

        toastr()->success('Barang berhasil dimasukkan ke keranjang sampah');
        return redirect()->route('barang.index');
    }

    /**
	 * Restore item from trash bin
     * 
     * Restore item from trash bin by changing the is_deleted property to false
     * 
     * @pathParam barang integer required
     * ID of the item to restore
     * 
     * @authenticated
	 *
     * @response {
     *      "status": 200,
     *      "success": true
     * }
	 */
    public function to_restore(Item $barang)
    {
        $barang->update([
            'is_deleted'=>0
        ]);

        toastr()->success('Barang berhasil direstore!');
        return redirect()->route('barang.sampah_index');
    }

    /**
	 * Delete item from database
     * 
     * Delete one item from database. (Can only be use from the trash bin page)
     * 
     * @pathParam barang integer required
     * ID of the item to put into trash bin
     * 
     * @authenticated
	 * @response {
     *      "status": 200,
     *      "success": true,
     * }
	 *
	 */
    public function destroy(Item $barang)
    {
        //delete image
        Storage::delete('public/img/itemImages/'. $barang->image_url);

        //delete post
        $barang->delete();

        //redirect to index
        toastr()->success('Barang berhasil dihapus!');
        return redirect()->route('barang.sampah_index');
    }

    /**
	 * Delete all items from trash bin
     * 
     * Delete all items which is_deleted property equals to true.
     * 
     * 
     * @authenticated
	 * @response {
     *      "status": 200,
     *      "success": true,
     * }
	 *
	 */
    public function destroy_all()
    {
        $items = Item::join('categories', 'categories.id', '=', 'items.category_id')
        ->join('colors', 'colors.id', '=', 'items.color_id')
        ->select('items.id','items.name', 'items.description', 'items.price', 'items.image_url', 'items.condition', 'items.size', 'items.region_of_origin', 'items.sex', 'categories.name AS category_name', 'colors.name AS color_name', 'items.is_sold')
        ->where('items.is_deleted','=',1)
        ->get();

        foreach($items as $item) {
            Storage::delete('public/img/itemImages/'. $item->image_url);

            $item->delete();
        }

        //redirect to index
        toastr()->success('Barang berhasil dihapus!');
        return redirect()->route('barang.sampah_index');
    }

    /**
	 * Restore all items from the trash bin
     * 
     * Change all items which is_deleted property equals to true to false.
     * 
     * 
	 * @response {
     *      "status": 200,
     *      "success": true,
     * }
	 *
	 */
    public function restore_all()
    {
        $items = Item::join('categories', 'categories.id', '=', 'items.category_id')
        ->join('colors', 'colors.id', '=', 'items.color_id')
        ->select('items.id','items.name', 'items.description', 'items.price', 'items.image_url', 'items.condition', 'items.size', 'items.region_of_origin', 'items.sex', 'categories.name AS category_name', 'colors.name AS color_name', 'items.is_sold')
        ->where('items.is_deleted','=',1)
        ->get();

        foreach($items as $item) {
            $item->update([
                'is_deleted'=>0
            ]);
        }

        //redirect to index
        toastr()->success('Barang berhasil direstore!');
        return redirect()->route('barang.sampah_index');
    }
}
