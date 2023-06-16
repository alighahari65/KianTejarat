<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeProduct;
use App\Models\AttributeProductValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::get();
        $attributeIds = Attribute::get()->pluck('id');

        foreach ($products as $key => $product) {
            foreach ($attributeIds as $key => $attributeId) {
                $product->attributes()->attach($attributeId);
            }
        }

        $attributeProductIds = AttributeProduct::get()->pluck('id');

        foreach ($attributeProductIds as $key => $attributeProductId) {
            $data[] = [
                'attribute_product_id' => $attributeProductId,
                'value' => collect(['سفید', 'مشکی', 'نقره ای'])->random(),
                'price' => collect([100000, 200000, 300000])->random(),
                'sell_count' => collect([5, 10, 15])->random(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        AttributeProductValue::insert($data);
    }
}
