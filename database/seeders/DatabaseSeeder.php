<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database based on current schema.
     */
    public function run(): void
    {
        // Seed users (with role column available in current schema)
        User::query()->delete();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::factory()->count(3)->create([
            'password' => Hash::make('admin123'),
            'role' => 'cashier',
        ]);

        // Seed products using existing ProductSeeder (fields: sku, name, category, unit, cost_price, sell_price, reorder_point)
        if (Product::count() === 0) {
            $this->call(ProductSeeder::class);
        }

        // Create initial inventory movements to reflect opening stock using allowed enum types
        // Allowed: PURCHASE, SALE, ADJUST, RETURN
        if (InventoryMovement::count() === 0) {
            $this->call(TransactionSeeder::class);
        }
    }
}
