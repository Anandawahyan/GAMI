<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $items = Item::join('categories', 'categories.id', '=', 'items.category_id')
        ->join('colors', 'colors.id', '=', 'items.color_id')
        ->select('items.id','items.name', 'items.description', 'items.price', 'items.image_url', 'items.condition', 'items.size', 'items.region_of_origin', 'items.sex', 'categories.name AS category_name', 'colors.name AS color_name', 'items.is_sold')
        ->where('items.is_deleted','=',0)
        ->get();

        return view('pages.admin.barang', ['items'=>$items, 'type_menu'=>'barang']);
    }

    public function sampah_index() {
        $items = Item::join('categories', 'categories.id', '=', 'items.category_id')
        ->join('colors', 'colors.id', '=', 'items.color_id')
        ->select('items.id','items.name', 'items.description', 'items.price', 'items.image_url', 'items.condition', 'items.size', 'items.region_of_origin', 'items.sex', 'categories.name AS category_name', 'colors.name AS color_name', 'items.is_sold')
        ->where('items.is_deleted','=',1)
        ->get();

        return view('pages.admin.barang-sampah', ['items'=>$items, 'type_menu'=>'barang']);
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        $colors = DB::table('colors')->get();
        
        return view('pages.admin.barang-create',["type_menu"=>'barang', 'categories'=>$categories, 'colors'=>$colors]);
    }

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

    public function to_trash(Item $barang)
    {
        $barang->update([
            'is_deleted'=>1
        ]);

        toastr()->success('Barang berhasil dimasukkan ke keranjang sampah');
        return redirect()->route('barang.index');
    }

    public function to_restore(Item $barang)
    {
        $barang->update([
            'is_deleted'=>0
        ]);

        toastr()->success('Barang berhasil direstore!');
        return redirect()->route('barang.sampah_index');
    }

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
}
