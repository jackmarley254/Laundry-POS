<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;
use App\Models\OnlineOrder;

class POSController extends Controller
{
    /**
     * Display the SmartWash dashboard.
     */
    public function dashboard()
    {
        $today = today();

        $validOrders = Order::query()
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'cancelled');
            });

        $todaySales = (clone $validOrders)
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        $totalOrders = (clone $validOrders)
            ->whereDate('created_at', $today)
            ->count();

        $pendingOrders = Order::where('status', 'pending')->count();

        // "Ready for Pickup" corresponds to the ready status.
        $readyOrders = Order::where('status', 'ready')->count();

        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Include all seven calendar dates, even dates with zero sales.
        $salesData = collect();

        $startDate = now()->subDays(6)->startOfDay();

        $dailySales = (clone $validOrders)
            ->whereBetween('created_at', [
                $startDate,
                now()->endOfDay(),
            ])
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i)->toDateString();

            $salesData->put(
                $date,
                (float) ($dailySales->get($date)->total ?? 0)
            );
        }

        return view('dashboard', compact(
            'todaySales',
            'totalOrders',
            'pendingOrders',
            'readyOrders',
            'recentOrders',
            'salesData'
        ));
    }

    /**
     * Display the SmartWash POS terminal.
     */
    public function index()
    {
        $services = Service::query()
            ->orderBy('name')
            ->get();

        return view('pos.index', compact('services'));
    }

    /**
     * Search customers using AJAX.
     */
    public function searchCustomer(Request $request)
    {
        $validated = $request->validate([
            'query' => ['nullable', 'string', 'max:100'],
        ]);

        $search = trim($validated['query'] ?? '');

        if ($search === '') {
            return response()->json([]);
        }

        $customers = Customer::query()
            ->where(function ($query) use ($search) {
                $query->where('phone', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
            })
            ->select('id', 'name', 'phone', 'address')
            ->orderBy('name')
            ->limit(10)
            ->get();

        return response()->json($customers);
    }

    /**
     * Create a walk-in POS order.
     */
    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],
            'customer_phone' => [
                'required',
                'string',
                'max:20',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
                'max:100',
            ],
            'items.*.service_id' => [
                'required',
                'integer',
                'distinct',
                'exists:services,id',
            ],
            'items.*.quantity' => [
                'required',
                'numeric',
                'gt:0',
                'max:10000',
            ],
            'paid_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'pickup_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
        ]);

        try {
            $order = DB::transaction(function () use ($validated) {
                $items = collect($validated['items']);

                $serviceIds = $items
                    ->pluck('service_id')
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->values();

                // Fetch trusted prices from the database, not the browser.
                $services = Service::query()
                    ->whereIn('id', $serviceIds)
                    ->get()
                    ->keyBy('id');

                if ($services->count() !== $serviceIds->count()) {
                    throw ValidationException::withMessages([
                        'items' => 'One or more selected services no longer exist.',
                    ]);
                }

                $total = 0;

                $preparedItems = $items->map(
                    function ($item) use ($services, &$total) {
                        $service = $services->get(
                            (int) $item['service_id']
                        );

                        $quantity = (float) $item['quantity'];
                        $price = (float) $service->price;

                        if ($price < 0) {
                            throw ValidationException::withMessages([
                                'items' => 'A selected service has an invalid price.',
                            ]);
                        }

                        $subtotal = round($price * $quantity, 2);
                        $total += $subtotal;

                        return [
                            'service_id' => $service->id,
                            'service_name' => $service->name,
                            'quantity' => $quantity,
                            'price' => $price,
                            'subtotal' => $subtotal,
                        ];
                    }
                );

                $total = round($total, 2);
                $paidAmount = round(
                    (float) ($validated['paid_amount'] ?? 0),
                    2
                );

                if ($paidAmount > $total) {
                    throw ValidationException::withMessages([
                        'paid_amount' => 'The amount paid cannot exceed the order total.',
                    ]);
                }

                $paymentStatus = $paidAmount >= $total
                    ? 'paid'
                    : ($paidAmount > 0 ? 'partial' : 'unpaid');

                $pickupDate = !empty($validated['pickup_date'])
                    ? Carbon::parse($validated['pickup_date'])
                    : now();

                $order = Order::create([
                    'customer_id' => null,
                    'customer_name' => trim($validated['customer_name']),
                    'customer_phone' => trim($validated['customer_phone']),
                    'invoice_no' => 'INV-'
                        . now()->format('Ymd')
                        . '-'
                        . Str::upper(Str::random(8)),
                    'pickup_date' => $pickupDate,
                    'delivery_date' => now()->addDays(3),
                    'total_amount' => $total,
                    'paid_amount' => $paidAmount,
                    'status' => 'pending',
                    'payment_status' => $paymentStatus,
                    'notes' => $validated['notes'] ?? null,
                ]);

                foreach ($preparedItems as $item) {
                    $order->items()->create($item);
                }

                return $order;
            });

            return redirect()
                ->route('pos.receipt', $order->id)
                ->with('success', 'SmartWash order created successfully.');

        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('SmartWash POS order creation failed.', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
            ]);

            return back()
                ->withInput()
                ->withErrors([
                    'order' => 'The order could not be saved. Please try again.',
                ]);
        }
    }

    /**
     * Update an order's processing status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,processing,ready,delivered,cancelled',
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            "Order #{$order->invoice_no} status updated to {$validated['status']}."
        );
    }

    /**
     * Display an order receipt.
     */
    public function receipt(Order $order)
    {
        $order->load('items');

        return view('pos.receipt', compact('order'));
    }

    /**
     * Display the order management list.
     */
    public function orderList()
    {
        $orders = Order::query()
            ->with('customer')
            ->latest()
            ->paginate(15);

        $validOrders = Order::query()
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'cancelled');
            });

        $todaySales = (clone $validOrders)
            ->whereDate('created_at', today())
            ->sum('total_amount');

        $weekSales = (clone $validOrders)
            ->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])
            ->sum('total_amount');

        $monthSales = (clone $validOrders)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');

        return view('orders.index', compact(
            'orders',
            'todaySales',
            'weekSales',
            'monthSales'
        ));
    }

    /**
     * Download an order report as PDF.
     */
    public function downloadReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => [
                'nullable',
                'date_format:Y-m-d',
                'required_with:end_date',
            ],
            'end_date' => [
                'nullable',
                'date_format:Y-m-d',
                'required_with:start_date',
                'after_or_equal:start_date',
            ],
        ]);

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;

        $query = Order::query()
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', '!=', 'cancelled');
            })
            ->with('items')
            ->latest();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        $orders = $query->get();

        $totalSales = $orders->sum('total_amount');

        $pdf = Pdf::loadView('orders.pdf', [
            'orders' => $orders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalSales' => $totalSales,
        ]);

        return $pdf->download(
            'smartwash-orders-report-' . now()->format('Y-m-d') . '.pdf'
        );
    }
}