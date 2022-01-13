<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inventory::create([
            'added_by' => 63,
            'product_category' => 'Machine',
            'product_name' => 'High Pressure Water Washer',
            'product_particulars' => '4000W',
            'client_name' => 'CAT.',
            'per_unit_price' => 7000,
            'latest_stock' => 252,
            'latest_stock_date' => '2021-8-16',
            'physically_found_quantity' => 252,
            'sales_quantity' => 0,
            'purchase_quantity' => 0,
            'stock_quantity_to_be_reported' => 252,
            'excess_quantity' => 0,
            'shortage_quantity' => 0,
            'remarks' => null,
        ]);
        Inventory::create([
            'added_by' => 63,
            'product_category' => 'Polisher',
            'product_name' => 'Turtle Max',
            'product_particulars' => 'Color Magic',
            'client_name' => 'Akhter Hossain',
            'per_unit_price' => 1500,
            'latest_stock' => 750,
            'latest_stock_date' => '2021-9-16',
            'physically_found_quantity' => 750,
            'sales_quantity' => 0,
            'purchase_quantity' => 0,
            'stock_quantity_to_be_reported' => 750,
            'excess_quantity' => 0,
            'shortage_quantity' => 0,
            'remarks' => null,
        ]);
        
        
    }
}
