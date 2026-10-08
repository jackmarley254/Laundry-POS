<?php

namespace App\Http\Controllers;

use App\Models\OnlineOrder;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineCustomerController extends Controller
{
    /**
     * PUBLIC
     *
     * Called by the landing page checkout form.
     *
     * No authentication required.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:100',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\s\-]{9,20}$/',
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'pickup_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'pickup_time' => [
                'required',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:500',
            ],

            'services' => [
                'required',
                'array',
                'min:1',
            ],

            'services.*.id' => [
                'required',
                'exists:services,id',
            ],

            'services.*.quantity' => [
                'required',
                'numeric',
                'min:0.5',
                'max:1000',
            ],
        ], [
            'services.required' => 'Please select at least one service.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Order + Calculate Total
        |--------------------------------------------------------------------------
        */

        $order = DB::transaction(function () use ($data) {

            $services = Service::whereIn(
                'id',
                collect($data['services'])
                    ->pluck('id')
                    ->unique()
            )
                ->get()
                ->keyBy('id');

            $items = [];

            $total = 0;

            $names = [];

            $qtySum = 0;

            foreach ($data['services'] as $line) {

                /*
                |--------------------------------------------------------------------------
                | Find Service
                |--------------------------------------------------------------------------
                */

                $service = $services->get($line['id']);

                /*
                |--------------------------------------------------------------------------
                | Safety Check
                |--------------------------------------------------------------------------
                */

                if (!$service) {
                    abort(
                        422,
                        'One of the selected services could not be found.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Quantity
                |--------------------------------------------------------------------------
                */

                $qty = (float) $line['quantity'];

                /*
                |--------------------------------------------------------------------------
                | Calculate Subtotal
                |--------------------------------------------------------------------------
                */

                $subtotal = round(
                    (float) $service->price * $qty,
                    2
                );

                /*
                |--------------------------------------------------------------------------
                | Order Item
                |--------------------------------------------------------------------------
                */

                $items[] = [
                    'service_id' => $service->id,
                    'name' => $service->name,
                    'price' => (float) $service->price,
                    'unit' => $service->unit,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];

                /*
                |--------------------------------------------------------------------------
                | Totals
                |--------------------------------------------------------------------------
                */

                $total += $subtotal;

                $qtySum += $qty;

                $names[] = $service->name;
            }

            /*
            |--------------------------------------------------------------------------
            | Create Online Order
            |--------------------------------------------------------------------------
            */

            return OnlineOrder::create([
                'customer_name' => $data['customer_name'],

                'phone' => $data['phone'],

                'email' => $data['email'] ?? null,

                'delivery_address' => $data['location'],

                'service_name' => implode(', ', $names),

                'quantity' => $qtySum,

                'items' => $items,

                'pickup_date' => $data['pickup_date'],

                'pickup_time' => $data['pickup_time'],

                'notes' => $data['notes'] ?? null,

                'total_amount' => $total,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Return Created Order
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Your order has been submitted successfully.',
            'order' => $order,
        ], 201);
    }


    /**
     * ADMIN
     *
     * Online orders dashboard/list page.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Summary Counts
        |--------------------------------------------------------------------------
        |
        | Counts are calculated against the entire orders table before
        | pagination so the dashboard cards represent all orders.
        |
        */

        $counts = [
            'total' => OnlineOrder::count(),

            'pending' => OnlineOrder::where(
                'status',
                'pending'
            )->count(),

            'processing' => OnlineOrder::where(
                'status',
                'processing'
            )->count(),

            'completed' => OnlineOrder::where(
                'status',
                'completed'
            )->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        $orders = OnlineOrder::latest()
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'online-orders.index',
            compact('orders', 'counts')
        );
    }


    /**
     * ADMIN
     *
     * Display a single online order.
     */
    public function show(OnlineOrder $order)
    {
        return view(
            'online-orders.show',
            compact('order')
        );
    }


    /**
     * ADMIN
     *
     * Update the laundry/order processing status.
     *
     * Supported statuses:
     * - pending
     * - processing
     * - ready
     * - completed
     * - delivered
     * - cancelled
     */
    public function updateStatus(
        Request $request,
        OnlineOrder $order
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,processing,ready,completed,delivered,cancelled',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Order Status
        |--------------------------------------------------------------------------
        */

        $order->update([
            'status' => $validated['status'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        |
        | AJAX requests receive JSON.
        | Normal form submissions are redirected back.
        |
        */

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Order #{$order->order_number} marked as {$validated['status']}.",
                'status' => $order->status,
                'order_id' => $order->id,
            ]);
        }

        return back()->with(
            'success',
            "Order #{$order->order_number} marked as {$validated['status']}."
        );
    }


    /**
     * ADMIN
     *
     * Update the payment status of an online order.
     *
     * Supported payment statuses:
     * - paid
     * - not_paid
     *
     * This method is used by the inline Payment Status dropdown
     * on the Online Orders dashboard.
     */
    public function updatePaymentStatus(
        Request $request,
        OnlineOrder $order
    ) {
        /*
        |--------------------------------------------------------------------------
        | Validate Payment Status
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'payment_status' => [
                'required',
                'in:paid,not_paid',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Payment Status
        |--------------------------------------------------------------------------
        */

        $order->update([
            'payment_status' => $validated['payment_status'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | JSON Response
        |--------------------------------------------------------------------------
        |
        | The inline dropdown uses AJAX/fetch(), so return JSON.
        |
        */

        return response()->json([
            'success' => true,

            'message' => $validated['payment_status'] === 'paid'
                ? "Order #{$order->order_number} has been marked as paid."
                : "Order #{$order->order_number} has been marked as not paid.",

            'payment_status' => $order->payment_status,

            'order_id' => $order->id,

            'order_number' => $order->order_number,
        ]);
    }
}