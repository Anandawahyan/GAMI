<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Jackets','T-Shirts','Shirts','Sweatshirts','Dress','Skirts','Shorts'];
        
        foreach($categories as $category) {
            DB::table('categories')->insert(['name'=>$category]);
        }
        
    }
}
