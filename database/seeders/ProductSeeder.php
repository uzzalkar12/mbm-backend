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
            ['name' => 'Tea', 'unit' => 'pcs'],
            ['name' => 'Sugar', 'unit' => 'pcs'],
            ['name' => 'Tea Bag', 'unit' => 'pcs'],
            ['name' => 'Green Tea', 'unit' => 'pcs'],
            ['name' => 'Black Tea', 'unit' => 'pcs'],
        ];
        $product_array = array();

        foreach ($products as $product) {
            $data['name'] = $product['name'];
            $data['unit'] = $product['unit'];
            $product_array[] = $data;
        }

        Product::query()->insert($product_array);
    }
}
