<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Period Parsing
        $period = $request->query('period', 'today'); // today, 7d, 30d
        $now = Carbon::now();
        
        switch ($period) {
            case '7d':
                $startDate = $now->copy()->subDays(6)->startOfDay();
                $previousStartDate = $startDate->copy()->subDays(7);
                $previousEndDate = $startDate->copy()->subSecond();
                $periodLabel = '7 Hari Terakhir';
                break;
            case '30d':
                $startDate = $now->copy()->subDays(29)->startOfDay();
                $previousStartDate = $startDate->copy()->subDays(30);
                $previousEndDate = $startDate->copy()->subSecond();
                $periodLabel = '30 Hari Terakhir';
                break;
            case 'today':
            default:
                $period = 'today';
                $startDate = $now->copy()->startOfDay();
                $previousStartDate = $startDate->copy()->subDay();
                $previousEndDate = $startDate->copy()->subSecond();
                $periodLabel = 'Hari Ini';
                break;
        }

        $endDate = $now->copy()->endOfDay();

        // 2. Base Query Object for Sales in Period
        // We join products to get the sell_price for revenue calculation
        $salesQuery = InventoryMovement::where('type', 'SALE')
            ->join('products', 'inventory_movements.product_id', '=', 'products.id');

        // Total Revenue & Transactions Current Period
        $currentSales = (clone $salesQuery)
            ->whereBetween('inventory_movements.created_at', [$startDate, $endDate])
            ->selectRaw('SUM(inventory_movements.qty * products.sell_price) as total_revenue, COUNT(inventory_movements.id) as total_transactions')
            ->first();

        $totalRevenue = (float) $currentSales->total_revenue ?? 0;
        $totalTransactions = (int) $currentSales->total_transactions ?? 0;

        // Total Revenue & Transactions Previous Period (for percentage change)
        $previousSales = (clone $salesQuery)
            ->whereBetween('inventory_movements.created_at', [$previousStartDate, $previousEndDate])
            ->selectRaw('SUM(inventory_movements.qty * products.sell_price) as total_revenue, COUNT(inventory_movements.id) as total_transactions')
            ->first();

        $prevRevenue = (float) $previousSales->total_revenue ?? 0;
        $prevTransactions = (int) $previousSales->total_transactions ?? 0;

        // 3. Percentage Changes Calculations
        $revenueChange = $this->calculatePercentageChange($prevRevenue, $totalRevenue);
        $transactionChange = $this->calculatePercentageChange($prevTransactions, $totalTransactions);

        // 4. Products Base Data
        $productCount = Product::count();
        $products = Product::with('movements')->get(); // eager load movements for current_stock
        
        // Low Stock calculation
        $lowStocksList = $products
            ->filter(fn($p) => $p->current_stock <= $p->reorder_point)
            ->sortBy('current_stock');
        
        $lowStockCount = $lowStocksList->count();
        $lowStocks = $lowStocksList->take(5)->values(); // Take top 5 for table

        // 5. Chart Data: Sales Trend (Line Chart)
        // Group by Date for the current period
        $salesTrend = (clone $salesQuery)
            ->whereBetween('inventory_movements.created_at', [$startDate, $endDate])
            ->selectRaw('DATE(inventory_movements.created_at) as date, SUM(inventory_movements.qty * products.sell_price) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartData = [];

        // Fill in missing dates with 0
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format('Y-m-d');
            $displayDate = $period === 'today' ? $currentDate->format('H:00') : $currentDate->format('d M');
            
            $chartLabels[] = $displayDate;
            $chartData[] = isset($salesTrend[$dateString]) ? (float) $salesTrend[$dateString]->total : 0;
            
            if ($period === 'today') {
               // For today, we actually want hourly, but since we grouped by date above, 
               // let's do a simplified daily view even for 'today' or refactor below:
               break; // Since it's only one day, data grouping above per DATE is enough for now, will yield 1 point.
            } else {
                $currentDate->addDay();
            }
        }
        
        // Quick fix for 'today' hourly data formatting
        if($period === 'today') {
             // Database agnostic hourly grouping for 'today'
             $todaySales = clone $salesQuery;
             $hourlySalesRaw = $todaySales
                ->whereBetween('inventory_movements.created_at', [$startDate, $endDate])
                ->select('inventory_movements.created_at', 'inventory_movements.qty', 'products.sell_price')
                ->get();
                
             $hourlySales = [];
             foreach($hourlySalesRaw as $sale) {
                 // Format as two digit hour (00-23)
                 $hour = $sale->created_at->format('H');
                 if(!isset($hourlySales[$hour])) $hourlySales[$hour] = 0;
                 $hourlySales[$hour] += ($sale->qty * $sale->sell_price);
             }
             
             $chartLabels = [];
             $chartData = [];
             
             // Generate hours 00 to 23
             for ($i = 0; $i < 24; $i++) {
                $hourStr = str_pad($i, 2, '0', STR_PAD_LEFT);
                $chartLabels[] = $hourStr . ':00';
                $chartData[] = isset($hourlySales[$hourStr]) ? (float) $hourlySales[$hourStr] : 0;
             }
        }

        // 6. Chart Data: Sales by Category (Donut Chart)
        $categorySales = clone $salesQuery;
        
        // Depending on DB driver, COALESCE/IFNULL differs. Fallback to application side aggregation for safety.
        $categorySalesRaw = $categorySales
            ->whereBetween('inventory_movements.created_at', [$startDate, $endDate])
            ->select('products.category', 'inventory_movements.qty', 'products.sell_price')
            ->get();
            
        $categoryTotals = [];
        foreach($categorySalesRaw as $sale) {
            $cat = $sale->category ?: 'Uncategorized';
            if(!isset($categoryTotals[$cat])) $categoryTotals[$cat] = 0;
            $categoryTotals[$cat] += ($sale->qty * $sale->sell_price);
        }
        
        arsort($categoryTotals); // Sort high to low
        $categoryLabels = array_keys($categoryTotals);
        $categoryDataValues = array_values($categoryTotals);

        // 7. Recent Transactions Table (Top 10)
        $recentTransactions = InventoryMovement::with('product')
            ->where('type', 'SALE')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($movement) {
                return [
                    'id' => $movement->id,
                    'time' => $movement->created_at->diffForHumans(),
                    'product_name' => $movement->product->name ?? 'Unknown',
                    'qty' => $movement->qty,
                    'total' => $movement->qty * ($movement->product->sell_price ?? 0),
                    'note' => $movement->note
                ];
            });

        // 8. Greeting
        $hour = $now->hour;
        if ($hour < 12) $greeting = 'Selamat Pagi';
        elseif ($hour < 15) $greeting = 'Selamat Siang';
        elseif ($hour < 18) $greeting = 'Selamat Sore';
        else $greeting = 'Selamat Malam';

        return view('dashboard', compact(
            'period', 'periodLabel', 'greeting',
            'totalRevenue', 'totalTransactions', 'productCount', 'lowStockCount',
            'revenueChange', 'transactionChange',
            'chartLabels', 'chartData',
            'categoryLabels', 'categoryDataValues',
            'recentTransactions', 'lowStocks'
        ));
    }

    private function calculatePercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0; // If previously 0 and now >0, +100%. If both 0, 0%.
        }
        
        return round((($newValue - $oldValue) / $oldValue) * 100, 1);
    }
}
