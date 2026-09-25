<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OnlineOrderController extends Controller
{
    /**
     * Display online orders.
     */
    public function index()
    {
        $orders = Order::latest()
            ->get();

        return view('online-orders.index', compact('orders'));
    }

    /**
     * Display a single online order.
     */
    public function show(Order $order)
    {
        return view('online-orders.show', compact('order'));
    }

    /**
     * Update online order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:pending,processing,ready,completed,delivered,cancelled',
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('online-orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}