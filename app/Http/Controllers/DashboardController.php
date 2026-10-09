<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OnlineOrder;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    /**
     * Display a unified SmartWash dashboard.
     *
     * Walk-in orders come from Order.
     * Online orders come from OnlineOrder.
     */
    public function index(): View
    {
        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Today's order counts
        |--------------------------------------------------------------------------
        */
        $walkInOrdersToday = Order::whereDate(
            'created_at',
            $today
        )->count();

        $onlineOrdersToday = OnlineOrder::whereDate(
            'created_at',
            $today
        )->count();

        $totalOrders = $walkInOrdersToday + $onlineOrdersToday;

        /*
        |--------------------------------------------------------------------------
        | All-time order counts
        |--------------------------------------------------------------------------
        */
        $walkInTotal = Order::count();
        $onlineTotal = OnlineOrder::count();

        $allOrders = $walkInTotal + $onlineTotal;

        /*
        |--------------------------------------------------------------------------
        | Today's combined sales
        |--------------------------------------------------------------------------
        | Cancelled orders are excluded.
        */
        $todaySales = $this->salesForDate($today);

        /*
        |--------------------------------------------------------------------------
        | Combined workflow counts
        |--------------------------------------------------------------------------
        */
        $pendingOrders =
            Order::where('status', 'pending')->count()
            + OnlineOrder::where('status', 'pending')->count();

        $readyOrders =
            Order::where('status', 'ready')->count()
            + OnlineOrder::where('status', 'ready')->count();

        /*
        |--------------------------------------------------------------------------
        | Combined sales chart: last seven days
        |--------------------------------------------------------------------------
        */
        $salesData = collect();

        for ($daysAgo = 6; $daysAgo >= 0; $daysAgo--) {
            $date = Carbon::today()->subDays($daysAgo);

            $salesData->put(
                $date->format('M d'),
                $this->salesForDate($date)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Normalize walk-in orders
        |--------------------------------------------------------------------------
        | Both models are converted into a common structure so the same
        | dashboard table can display either kind of order.
        */
        $walkInRecent = Order::latest()
            ->take(10)
            ->get()
            ->map(function ($order) {
                return (object) [
                    'id' => $order->id,

                    'source_type' => 'walk_in',

                    'display_number' =>
                        $order->invoice_no
                        ?? $order->order_number
                        ?? ('POS-' . $order->id),

                    'invoice_no' =>
                        $order->invoice_no
                        ?? $order->order_number
                        ?? ('POS-' . $order->id),

                    'customer_name' =>
                        $order->customer_name ?? 'Walk-in Customer',

                    'total_amount' => (float) (
                        $order->total_amount ?? 0
                    ),

                    'status' => $order->status ?? 'pending',

                    'created_at' => $order->created_at,

                    'phone' => $order->phone ?? null,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Normalize online orders
        |--------------------------------------------------------------------------
        */
        $onlineRecent = OnlineOrder::latest()
            ->take(10)
            ->get()
            ->map(function ($order) {
                return (object) [
                    'id' => $order->id,

                    'source_type' => 'online',

                    'display_number' =>
                        $order->order_number
                        ?? ('WEB-' . $order->id),

                    'invoice_no' =>
                        $order->order_number
                        ?? ('WEB-' . $order->id),

                    'customer_name' =>
                        $order->customer_name ?? 'Online Customer',

                    'total_amount' => (float) (
                        $order->total_amount ?? 0
                    ),

                    'status' => $order->status ?? 'pending',

                    'created_at' => $order->created_at,

                    'phone' => $order->phone ?? null,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Combine and sort both order sources
        |--------------------------------------------------------------------------
        */
        $recentOrders = $walkInRecent
            ->concat($onlineRecent)
            ->sortByDesc(function ($order) {
                return $order->created_at
                    ? $order->created_at->timestamp
                    : 0;
            })
            ->take(10)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Render dashboard
        |--------------------------------------------------------------------------
        */
        return view('dashboard', compact(
            'todaySales',
            'totalOrders',
            'allOrders',
            'pendingOrders',
            'readyOrders',
            'walkInOrdersToday',
            'onlineOrdersToday',
            'salesData',
            'recentOrders'
        ));
    }

    /**
     * Calculate combined sales for one date.
     */
    private function salesForDate(Carbon $date): float
    {
        $walkInSales = Order::whereDate('created_at', $date)
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'cancelled');
            })
            ->sum('total_amount');

        $onlineSales = OnlineOrder::whereDate('created_at', $date)
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'cancelled');
            })
            ->sum('total_amount');

        return (float) $walkInSales + (float) $onlineSales;
    }
}