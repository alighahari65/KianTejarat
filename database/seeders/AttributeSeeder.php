<?php

namespace Database\Seeders;

use Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attrs = [
            ['title' => 'سایز'],
            ['title' => 'رنگ'],

        ];

        foreach ($attrs as $key => $attr) {
            $insertData[] = [
                'title' => $attr['title'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('attributes')->insert($insertData);
    }
}
