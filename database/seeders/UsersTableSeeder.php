<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->select('users.id')->get();

        foreach($users as $user) {
            DB::table('users')->where('id', '=', $user->id)->update(['role' => 'customer']);
        }
    }
}
