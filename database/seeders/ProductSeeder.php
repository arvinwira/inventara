<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Makanan
            ['sku' => 'IND-01', 'name' => 'Indomie Goreng Original', 'cost_price' => 2500, 'sell_price' => 3000, 'reorder_point' => 50],
            ['sku' => 'IND-02', 'name' => 'Indomie Kuah Ayam Bawang', 'cost_price' => 2300, 'sell_price' => 3000, 'reorder_point' => 50],
            ['sku' => 'SDB-01', 'name' => 'Sedaap Mie Goreng', 'cost_price' => 2500, 'sell_price' => 3000, 'reorder_point' => 50],
            ['sku' => 'SRR-01', 'name' => 'Sari Roti Tawar Spesial', 'cost_price' => 14000, 'sell_price' => 17000, 'reorder_point' => 10],
            
            // Minuman Ringan
            ['sku' => 'AQA-01', 'name' => 'Aqua 600ml', 'cost_price' => 2500, 'sell_price' => 3500, 'reorder_point' => 48],
            ['sku' => 'POC-01', 'name' => 'Pocari Sweat 500ml', 'cost_price' => 6000, 'sell_price' => 7500, 'reorder_point' => 24],
            ['sku' => 'THB-01', 'name' => 'Teh Botol Sosro 450ml', 'cost_price' => 3500, 'sell_price' => 5000, 'reorder_point' => 24],
            
            // Snack
            ['sku' => 'QTL-01', 'name' => 'Chitato Sapi Panggang 68g', 'cost_price' => 8500, 'sell_price' => 10500, 'reorder_point' => 20],
            ['sku' => 'TRT-01', 'name' => 'Taro Net Seaweed 65g', 'cost_price' => 6500, 'sell_price' => 8000, 'reorder_point' => 20],
            ['sku' => 'BGB-01', 'name' => 'Beng-Beng Shareit', 'cost_price' => 12000, 'sell_price' => 15000, 'reorder_point' => 10],

            // Kebutuhan Harian Pribadi
            ['sku' => 'LFB-01', 'name' => 'Lifebuoy Sabun Mandi 85g', 'cost_price' => 3500, 'sell_price' => 4500, 'reorder_point' => 30],
            ['sku' => 'PPD-01', 'name' => 'Pepsodent Pasta Gigi 190g', 'cost_price' => 11000, 'sell_price' => 13500, 'reorder_point' => 20],
            
            // Bahan Pokok / Sembako
            ['sku' => 'GKU-01', 'name' => 'Gulaku 1kg', 'cost_price' => 15000, 'sell_price' => 17500, 'reorder_point' => 20],
            ['sku' => 'BMS-01', 'name' => 'Bimoli Minyak Goreng 2L', 'cost_price' => 36000, 'sell_price' => 40000, 'reorder_point' => 12],
            ['sku' => 'TJN-01', 'name' => 'Telur Ayam Negeri /kg', 'cost_price' => 26000, 'sell_price' => 29000, 'reorder_point' => 30],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
