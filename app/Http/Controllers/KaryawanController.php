<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    public function index() {
        $users = User::where('role','=','admin')->get();

        return view('pages.admin.karyawan',["type_menu"=>'', "users"=>$users]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'namaKaryawan' => 'required|string|max:255',
            'roleKaryawan' => 'required',
            'sexKaryawan' => 'required',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:8',
        ]);

        $user = new User();
        $user->name = $request->namaKaryawan;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->roleKaryawan;
        $user->sex = $request->sexKaryawan;
        $user->save();

        toastr()->success('Berhasil menambah data karyawan');
        return redirect()->route('karyawan.index');
    }

    public function destroy(User $karyawan) {
        $karyawan->delete();

        toastr()->success('Berhasil menghapus data karyawan');
        return redirect()->route('karyawan.index');
    }

    public function get_random_password() {
        $response['data'] = Str::random(8);
        return response()->json($response);
    }


}
