<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function monthlySales()
    {
        // Get the current month and year
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // 1. Calculate Total Sales for the Month
        $totalSales = Order::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        // 2. Calculate Total Orders Count
        $totalOrders = Order::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('status', '!=', 'cancelled')
            ->count();

        // 3. Get Daily Breakdown for the Chart (Group by Date)
        $dailySalesData = Order::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('status', '!=', 'cancelled')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 4. Get Detailed List of Orders for the Table
        $monthlyOrders = Order::with('customer')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('reports.monthly_sales', compact(
            'totalSales', 
            'totalOrders', 
            'dailySalesData', 
            'monthlyOrders'
        ));
    }
}