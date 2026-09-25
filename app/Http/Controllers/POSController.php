<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

use Barryvdh\DomPDF\Facade\Pdf; // CORRECTED: Changed from Illuminate\Support\Pdf
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class POSController extends Controller
{
    /**
     * Display the Dashboard.
     */
    public function dashboard()
    {
        // 1. Calculate Key Metrics
        $todaySales = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $totalOrders = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        // CHANGE: Count 'delivered' orders as 'Ready for Pickup'
        $readyOrders = Order::where('status', 'delivered')->count();

        // 2. Get Recent Orders
        $recentOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // 3. Data for Chart (Last 7 Days Sales)
        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('status', '!=', 'cancelled')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('total', 'date');

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
     * Display the POS Terminal.
     */
    // public function index()
    // {
    //     // Get filter inputs
    //     $startDate = request('start_date');
    //     $endDate = request('end_date');

    //     // Base Query
    //     $query = Order::latest();

    //     // Apply Date Filter if present
    //     if ($startDate && $endDate) {
    //         $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
    //     }

    //     // Get Orders with Pagination
    //     $orders = $query->paginate(15);

    //     // Calculate Stats
    //     if ($startDate && $endDate) {
    //         // If filter is active, calculate total for that period
    //         $todaySales = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->sum('total_amount');
    //     } else {
    //         // Default: Today's sales
    //         $todaySales = Order::whereDate('created_at', today())->sum('total_amount');
    //     }

    //     // These usually stay the same regardless of filter
    //     $weekSales = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount');
    //     $monthSales = Order::whereMonth('created_at', now()->month)->sum('total_amount');

    //     return view('orders.index', compact('orders', 'todaySales', 'weekSales', 'monthSales'));
    // }
public function index()
{
    // Fetch all services from the database
    $services = Service::all(); 
    
    // Pass the $services variable to the view
    return view('pos.index', compact('services')); 
}
    /**
     * Search Customer (AJAX).
     */
    public function searchCustomer(Request $request)
    {
        $search = $request->get('query');

        $customers = Customer::where('phone', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->select('id', 'name', 'phone', 'address')
            ->limit(10)
            ->get();

        return response()->json($customers);
    }

    /**
     * Store the Order.
     */
    public function storeOrder(Request $request)
    {
        // 1. Validation
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|numeric|min:0.1',
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'pickup_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            // 2. Determine Dates
            $pickupDate = $request->pickup_date ? \Carbon\Carbon::parse($request->pickup_date) : now();
            $deliveryDate = now()->addDays(3);

            // 3. Create Order
            $order = Order::create([
                'customer_id'      => null,
                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone,
                'invoice_no'       => 'INV-' . date('Ymd') . '-' . Str::upper(Str::random(4)),
                'pickup_date'      => $pickupDate,
                'delivery_date'    => $deliveryDate,
                'total_amount'     => 0,
                'paid_amount'      => $request->paid_amount ?? 0,
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'notes'            => $request->notes,
            ]);

            // 4. Add Items and Calculate Total
            $total = 0;
            foreach ($request->items as $item) {
                $service = Service::find($item['service_id']);

                if (!$service) continue;

                $subtotal = $service->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $service->id,
                    'service_name' => $service->name,
                    'quantity' => $item['quantity'],
                    'price' => $service->price,
                    'subtotal' => $subtotal
                ]);

                $total += $subtotal;
            }

            // 5. Update Order Total and Payment Status
            $order->total_amount = $total;

            if ($order->paid_amount >= $total) {
                $order->payment_status = 'paid';
            } elseif ($order->paid_amount > 0) {
                $order->payment_status = 'partial';
            } else {
                $order->payment_status = 'unpaid';
            }

            $order->save();

            DB::commit();

            return redirect()->route('pos.receipt', $order->id)
                ->with('success', 'Order created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            // THIS WILL SHOW THE ACTUAL ERROR ON SCREEN
            dd("Error found: " . $e->getMessage());
        }
    }

    /**
     * Update Order Status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', "Order #{$order->invoice_no} status updated to {$request->status}.");
    }

    /**
     * Display the Receipt.
     */
    public function receipt(Order $order)
    {
        // We removed 'customer' because we save name/phone directly on the order now.
        // We removed 'items.service' because we save service_name directly on the item now.
        $order->load('items');
        return view('pos.receipt', compact('order'));
    }

    /**
     * Display list of orders (Admin/Management).
     */
    public function orderList()
    {
        // 1. Get Orders with Pagination
        $orders = Order::latest()->paginate(15);

        // 2. Calculate Totals (Excluding Cancelled orders for financial accuracy)
        $todaySales = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $weekSales = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        $monthSales = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');

        return view('orders.index', compact('orders', 'todaySales', 'weekSales', 'monthSales'));
    }

    public function downloadReport()
    {
        $startDate = request('start_date');
        $endDate = request('end_date');

        $query = Order::latest();

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $orders = $query->get(); // Use get() instead of paginate for PDFs
        $totalSales = $orders->sum('total_amount');

        // Load a specific PDF view (you can reuse the table HTML in a clean layout)
        $pdf = Pdf::loadView('orders.pdf', compact('orders', 'startDate', 'endDate', 'totalSales'));

        return $pdf->download('orders-report-' . date('Y-m-d') . '.pdf');
    }
}