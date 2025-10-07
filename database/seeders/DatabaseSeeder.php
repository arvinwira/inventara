<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users & roles
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::factory()->count(200)->create([
            'password' => Hash::make('admin123'),
            'role' => 'cashier',
        ]);

        // Massive seed for core entities
        $faker = \Faker\Factory::create();

        DB::transaction(function () use ($faker) {
            // Categories
            $categories = [];
            for ($i = 1; $i <= 12; $i++) {
                $name = ucfirst($faker->unique()->word());
                $categories[] = [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => $faker->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('categories')->insert($categories);

            $categoryIds = DB::table('categories')->pluck('id')->all();

            // Suppliers
            $suppliers = [];
            for ($i = 1; $i <= 50; $i++) {
                $suppliers[] = [
                    'name' => $faker->company(),
                    'email' => $faker->safeEmail(),
                    'phone' => $faker->phoneNumber(),
                    'address' => $faker->address(),
                    'notes' => $faker->sentence(),
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('suppliers')->insert($suppliers);
            $supplierIds = DB::table('suppliers')->pluck('id')->all();

            // Products (a lot)
            $products = [];
            $productCount = 1000; // adjust if needed
            for ($i = 1; $i <= $productCount; $i++) {
                $name = ucfirst($faker->unique()->words(rand(1, 3), true));
                $cost = $faker->randomFloat(2, 1, 200);
                $price = round($cost * $faker->randomFloat(2, 1.1, 1.8), 2);
                $initialStock = $faker->numberBetween(0, 200);
                $products[] = [
                    'sku' => strtoupper(Str::random(10)),
                    'name' => $name,
                    'category_id' => $faker->randomElement($categoryIds),
                    'unit' => 'pcs',
                    'barcode' => $faker->boolean(60) ? (string) $faker->ean13() : null,
                    'price' => $price,
                    'cost' => $cost,
                    'stock' => $initialStock,
                    'reorder_point' => $faker->numberBetween(0, 30),
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ];
            }
            // Insert in chunks to avoid memory spikes
            foreach (array_chunk($products, 200) as $chunk) {
                DB::table('products')->insert($chunk);
            }

            $productIds = DB::table('products')->pluck('id')->all();

            // Opening stock movements for initial stock values
            $movements = [];
            $productStocks = DB::table('products')->select('id', 'stock')->get();
            foreach ($productStocks as $p) {
                if ($p->stock > 0) {
                    $movements[] = [
                        'product_id' => $p->id,
                        'type' => 'opening',
                        'quantity' => $p->stock,
                        'reference_number' => null,
                        'reference_type' => null,
                        'reference_id' => null,
                        'notes' => 'Initial stock seeding',
                        'moved_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            foreach (array_chunk($movements, 500) as $chunk) {
                DB::table('stock_movements')->insert($chunk);
            }

            // Purchase Orders (increase stock)
            $poCount = 120;
            for ($i = 0; $i < $poCount; $i++) {
                $orderedAt = Carbon::now()->subDays(rand(10, 90))->setTime(rand(8,18), rand(0,59));
                $receivedAt = (clone $orderedAt)->addDays(rand(0, 7));
                $poNumber = 'PO-' . strtoupper(Str::random(8));
                $supplierId = $faker->randomElement($supplierIds);
                $poId = DB::table('purchase_orders')->insertGetId([
                    'order_number' => $poNumber,
                    'supplier_id' => $supplierId,
                    'status' => 'received',
                    'ordered_at' => $orderedAt,
                    'received_at' => $receivedAt,
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax' => 0,
                    'total' => 0,
                    'notes' => $faker->optional()->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $itemsCount = rand(3, 8);
                $items = [];
                $poSubtotal = 0;
                for ($j = 0; $j < $itemsCount; $j++) {
                    $productId = $faker->randomElement($productIds);
                    $qty = $faker->numberBetween(5, 50);
                    $unitCost = DB::table('products')->where('id', $productId)->value('cost');
                    $sub = round($unitCost * $qty, 2);
                    $items[] = [
                        'purchase_order_id' => $poId,
                        'product_id' => $productId,
                        'quantity' => $qty,
                        'unit_cost' => $unitCost,
                        'subtotal' => $sub,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $poSubtotal += $sub;

                    // Movement IN and update product stock
                    DB::table('stock_movements')->insert([
                        'product_id' => $productId,
                        'type' => 'purchase',
                        'quantity' => $qty,
                        'reference_number' => $poNumber,
                        'reference_type' => 'purchase_orders',
                        'reference_id' => $poId,
                        'notes' => 'PO received',
                        'moved_at' => $receivedAt,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::table('products')->where('id', $productId)->increment('stock', $qty);
                }
                DB::table('purchase_order_items')->insert($items);
                $tax = round($poSubtotal * 0.11, 2);
                $total = $poSubtotal + $tax;
                DB::table('purchase_orders')->where('id', $poId)->update([
                    'subtotal' => $poSubtotal,
                    'tax' => $tax,
                    'total' => $total,
                ]);
            }

            // Sales (decrease stock)
            $cashierIds = DB::table('users')->where('role', 'cashier')->pluck('id')->all();
            $saleCount = 300;
            for ($i = 0; $i < $saleCount; $i++) {
                $soldAt = Carbon::now()->subDays(rand(0, 30))->setTime(rand(8,21), rand(0,59));
                $saleNumber = 'SL-' . strtoupper(Str::random(8));
                $userId = $faker->randomElement($cashierIds);
                $saleId = DB::table('sales')->insertGetId([
                    'sale_number' => $saleNumber,
                    'user_id' => $userId,
                    'sold_at' => $soldAt,
                    'payment_method' => $faker->randomElement(['cash','card','e-wallet','transfer']),
                    'subtotal' => 0,
                    'discount' => 0,
                    'tax' => 0,
                    'total' => 0,
                    'paid_amount' => 0,
                    'change_amount' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $itemsCount = rand(1, 5);
                $items = [];
                $saleSubtotal = 0;
                for ($j = 0; $j < $itemsCount; $j++) {
                    $productId = $faker->randomElement($productIds);
                    $unitPrice = DB::table('products')->where('id', $productId)->value('price');
                    $available = (int) DB::table('products')->where('id', $productId)->value('stock');
                    $maxQty = max(1, min(10, $available));
                    $qty = $faker->numberBetween(1, $maxQty);
                    $sub = round($unitPrice * $qty, 2);
                    $items[] = [
                        'sale_id' => $saleId,
                        'product_id' => $productId,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'discount' => 0,
                        'subtotal' => $sub,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $saleSubtotal += $sub;

                    // Movement OUT and update product stock
                    DB::table('stock_movements')->insert([
                        'product_id' => $productId,
                        'type' => 'sale',
                        'quantity' => -$qty,
                        'reference_number' => $saleNumber,
                        'reference_type' => 'sales',
                        'reference_id' => $saleId,
                        'notes' => 'Sale transaction',
                        'moved_at' => $soldAt,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::table('products')->where('id', $productId)->decrement('stock', $qty);
                }
                DB::table('sale_items')->insert($items);

                $tax = round($saleSubtotal * 0.11, 2);
                $total = $saleSubtotal + $tax;
                $paid = $total; // assume fully paid
                DB::table('sales')->where('id', $saleId)->update([
                    'subtotal' => $saleSubtotal,
                    'tax' => $tax,
                    'total' => $total,
                    'paid_amount' => $paid,
                    'change_amount' => 0,
                ]);
            }
        });
    }
}
