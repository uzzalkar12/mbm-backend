<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_stocks = Product::query()->get();
        $product_stock_array = array();

        foreach ($product_stocks as $product)
        {
            $data['product_id']    = $product->id;
            $data['quantity']      = 500;
            $data['unit_price']    = 100;
            $product_stock_array[] = $data;
        }

        ProductStock::query()->insert($product_stock_array);
    }
}
