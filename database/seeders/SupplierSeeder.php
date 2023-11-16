<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = ['ACI', 'Megna', 'Shopno'];
        $supplier_array = array();

        foreach ($suppliers as $supplier)
        {
            $data['name']    = $supplier;
            $supplier_array[] = $data;
        }

        Supplier::query()->insert($supplier_array);
    }
}
