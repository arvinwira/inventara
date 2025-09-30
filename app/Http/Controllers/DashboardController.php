<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // jumlah produk
        $productCount = Product::count();

        // hitung low stock (butuh accessor current_stock di Product)
        $products = Product::with('movements')->get(); // preload biar akses current_stock ga N+1
        $lowStocks = $products
            ->filter(fn($p) => $p->current_stock <= $p->reorder_point)
            ->sortBy('current_stock')
            ->take(10)
            ->values();

        $lowStockCount = $lowStocks->count();

        return view('dashboard', compact(
            'productCount', 'lowStockCount', 'lowStocks'
        ));
    }
}
