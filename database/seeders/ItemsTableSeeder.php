<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [];

        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        $regions = ['US', 'Europe', 'Asia'];
        $colors = [1, 2, 3, 4, 6, 7, 8, 9, 10, 11];
        $categoryIds = range(1, 7);
        $sexes = ['Laki-laki','Perempuan','Unisex'];

        for ($i = 0; $i < 5; $i++) {
            $colorId = $colors[rand(0, 9)];
            $size = $sizes[rand(0, 4)];
            $region = $regions[rand(0, 2)];
            $categoryId = $categoryIds[rand(0, 6)];
            $isSold = false;
            $price = rand(100000, 500000);
            $sex = $sexes[rand(0,2)];

            $item = [
                'name' => 'Item ' . (25 + $i),
                'description' => 'Description for Item ' . ($i + 1),
                'price' => $price,
                'image_url' => 'https://example.com/image-' . ($i + 1) . '.jpg',
                'condition' => 'New',
                'size' => $size,
                'region_of_origin' => $region,
                'category_id' => $categoryId,
                'color_id' => $colorId,
                'is_sold' => $isSold,
                'sex'=> $sex,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('items')->insert($item);
        }
    }
}
