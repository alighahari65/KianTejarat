<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['user_id' => 1, 'title' => 'iphone10', 'image_location' => 'storage/images/1.jpeg'],
            ['user_id' => 1, 'title' => 'iphone13', 'image_location' => 'storage/images/1.jpeg']
        ];

        foreach ($products as $key => $product) {
            $data[] = [
                'user_id'        => $product['user_id'],
                'title'          => $product['title'],
                'image_location' => $product['image_location'],

            ];
        }

        Product::insert($data);
    }
}
