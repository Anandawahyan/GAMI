<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = ['Red','Yellow','Green','Blue','Green','Multi','Navy','Netral','Brown','Pink','Purple'];

        foreach($colors as $color) {
            DB::table('colors')->insert(['name'=>$color]);
        }
    }
}
