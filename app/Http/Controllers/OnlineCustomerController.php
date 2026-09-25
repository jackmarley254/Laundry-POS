<?php
// app/Http/Controllers/OnlineCustomerController.php
namespace App\Http\Controllers;

use App\Models\OnlineOrder;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineCustomerController extends Controller
{
    /**
     * PUBLIC — called by the landing page checkout form (no auth).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'        => 'required|string|max:100',
            'phone'                => ['required', 'string', 'max:20', 'regex:/^[0-9+\s\-]{9,20}$/'],
            'email'                => 'nullable|email|max:150',
            'location'             => 'required|string|max:255',
            'pickup_date'          => 'required|date|after_or_equal:today',
            'pickup_time'          => 'required',
            'notes'                => 'nullable|string|max:500',
            'services'             => 'required|array|min:1',
            'services.*.id'        => 'required|exists:services,id',
            'services.*.quantity'  => 'required|numeric|min:0.5|max:1000',
        ], [
            'services.required' => 'Please select at least one service.',
        ]);

        $order = DB::transaction(function () use ($data) {
            $services = Service::whereIn('id', collect($data['services'])->pluck('id'))->get()->keyBy('id');

            $items = [];
            $total = 0;
            $names = [];
            $qtySum = 0;

            foreach ($data['services'] as $line) {
                $service = $services[$line['id']];
                $qty     = (float) $line['quantity'];
                $subtotal = round($service->price * $qty, 2);

                $items[] = [
                    'service_id' => $service->id,
                    'name'       => $service->name,
                    'price'      => $service->price,
                    'unit'       => $service->unit,
                    'quantity'   => $qty,
                    'subtotal'   => $subtotal,
                ];

                $total  += $subtotal;
                $qtySum += $qty;
                $names[] = $service->name;
            }

            return OnlineOrder::create([
                'customer_name'    => $data['customer_name'],
                'phone'            => $data['phone'],
                'email'            => $data['email'] ?? null,
                'delivery_address' => $data['location'],
                'service_name'     => implode(', ', $names),
                'quantity'         => $qtySum,
                'items'            => $items,
                'pickup_date'      => $data['pickup_date'],
                'pickup_time'      => $data['pickup_time'],
                'notes'            => $data['notes'] ?? null,
                'total_amount'     => $total,
            ]);
        });

        return response()->json(['order' => $order], 201);
    }

    /**
     * ADMIN — list page.
     */
    public function index(Request $request)
    {
        // Compute counts against the WHOLE table first, before paginating,
        // so the summary cards aren't limited to just the current page of 15.
        $counts = [
            'total'      => OnlineOrder::count(),
            'pending'    => OnlineOrder::where('status', 'pending')->count(),
            'processing' => OnlineOrder::where('status', 'processing')->count(),
            'completed'  => OnlineOrder::where('status', 'completed')->count(),
        ];

        $orders = OnlineOrder::latest()->paginate(15)->withQueryString();

        return view('online-orders.index', compact('orders', 'counts'));
    }

    /**
     * ADMIN — single order detail.
     */
    public function show(OnlineOrder $order)
    {
        return view('online-orders.show', compact('order'));
    }

    /**
     * ADMIN — change status from the list or detail page.
     */
    public function updateStatus(Request $request, OnlineOrder $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', "Order #{$order->order_number} marked as {$request->status}.");
    }
}