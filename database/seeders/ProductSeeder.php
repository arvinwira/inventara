<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'sku' => 'PRD001',
                'name' => 'Indomie Goreng',
                'category' => 'Makanan',
                'unit' => 'pcs',
                'cost_price' => 2500,
                'sell_price' => 3500,
                'reorder_point' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD002',
                'name' => 'Aqua 600ml',
                'category' => 'Minuman',
                'unit' => 'botol',
                'cost_price' => 2000,
                'sell_price' => 4000,
                'reorder_point' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD003',
                'name' => 'Roti Sari Roti',
                'category' => 'Makanan',
                'unit' => 'pcs',
                'cost_price' => 5000,
                'sell_price' => 7500,
                'reorder_point' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
