<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\InventoryMovement;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        if ($products->isEmpty()) return;

        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now();

        // 1. Initial Purchase (Stock-in) for all products 30 days ago
        foreach ($products as $p) {
            InventoryMovement::create([
                'product_id' => $p->id,
                'type' => 'PURCHASE',
                'qty' => rand(50, 200),
                'note' => 'Initial stock seeding',
                'created_at' => $startDate,
                'updated_at' => $startDate,
            ]);
        }

        // 2. Simulate daily sales
        for ($date = $startDate->copy()->addDay(); $date <= $endDate; $date->addDay()) {
            // Random number of transactions per day (5 to 25)
            $numTransactions = rand(5, 25);
            for ($i = 0; $i < $numTransactions; $i++) {
                $product = $products->random();
                
                // Random time during business hours (08:00 - 21:00)
                $txDate = $date->copy()->setTime(rand(8, 20), rand(0, 59), rand(0, 59));
                
                // Allow transactions up to current time if $date is today
                if ($txDate > $endDate) continue;
                
                $qty = rand(1, 4);

                InventoryMovement::insert([
                    'product_id' => $product->id,
                    'type' => 'SALE',
                    'qty' => $qty,
                    'note' => 'Penjualan kasir',
                    'created_at' => $txDate,
                    'updated_at' => $txDate,
                ]);
            }
        }
    }
}
