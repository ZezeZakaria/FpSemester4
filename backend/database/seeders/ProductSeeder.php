<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('product')
            ->insert([
                'product_name' => 'Produk 1',
                'description' => 'Description',
                'photo' => 'products/photo1.jpg',
                'stock' => 10,
                'size' => '',
                'status' => 'active',
                'price' => 10000,
                'is_featured' => 0,
                'cat_id' => 1
            ]);
    }
}
