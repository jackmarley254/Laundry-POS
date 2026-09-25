<x-layout>
    @section('title', 'Order Management')

    @section('content')
        <!-- Modern Dashboard Styles -->
        <style>
            /* 1. Layout & Background */
            body {
                background-color: #f4f7fa; /* Soft gray background */
            }

            /* 2. Stats Cards - Gradients & Glassmorphism */
            .stats-card {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
                color: #fff;
            }

            .stats-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            /* Decorative circle in card background */
            .stats-card::before {
                content: '';
                position: absolute;
                top: -30px;
                right: -30px;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.1);
            }

            .stats-icon {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(5px);
                font-size: 1.5rem;
            }

            /* Gradient Definitions */
            .bg-gradient-primary { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); }
            .bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
            .bg-gradient-info { background: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%); }

            /* 3. Form & Filter Section */
            .filter-card {
                background: #fff;
                border-radius: 1rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
                border: none;
            }
            
            .filter-active {
                border-color: #2575fc !important;
                box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.15);
            }

            /* 4. Table Styling */
            .table-container {
                background: #fff;
                border-radius: 1rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
                overflow: hidden; /* Ensures rounded corners */
            }

            .table-modern thead th {
                background-color: #f8fafc;
                border-bottom: 2px solid #e2e8f0;
                color: #64748b;
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.75rem;
                letter-spacing: 0.8px;
                padding: 1.2rem 1rem;
            }

            .table-modern tbody tr {
                border-bottom: 1px solid #f1f5f9;
                transition: background 0.2s;
            }

            .table-modern tbody tr:last-child {
                border-bottom: none;
            }

            .table-modern tbody tr:hover {
                background-color: #f8fafc;
            }

            .table-modern td {
                padding: 1.2rem 1rem;
                vertical-align: middle;
                color: #334155;
            }

            /* 5. UI Elements (Badges, Dropdowns, Buttons) */
            .badge-status {
                padding: 0.6em 1.2em;
                font-size: 0.75rem;
                font-weight: 600;
                border-radius: 50rem; /* Pill shape */
                letter-spacing: 0.3px;
            }

            /* Sleek Select Dropdown */
            .status-select {
                border: 2px solid #e2e8f0;
                border-radius: 50rem;
                padding: 0.4rem 1rem;
                font-size: 0.8rem;
                font-weight: 600;
                background-color: #fff;
                cursor: pointer;
                transition: all 0.2s;
            }

            .status-select:focus {
                box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.2);
                border-color: #2575fc;
            }

            /* Receipt Button */
            .btn-receipt {
                border-radius: 50rem;
                padding: 0.4rem 1rem;
                font-size: 0.8rem;
                font-weight: 600;
                border: 2px solid #e2e8f0;
                background: #fff;
                color: #334155;
                transition: all 0.2s;
            }

            .btn-receipt:hover {
                background: #2575fc;
                color: #fff;
                border-color: #2575fc;
            }

            /* Section Titles */
            .section-title {
                font-weight: 700;
                color: #1e293b;
                letter-spacing: -0.5px;
            }
        </style>

        <div class="container-fluid py-4">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1 section-title">Order Management</h3>
                    <p class="text-muted small mb-0">Monitor sales, filter records, and manage order statuses.</p>
                </div>
            </div>

            <!-- ==================== FILTER SECTION ==================== -->
            <div class="card filter-card mb-4">
                <div class="card-body py-4 px-4">
                    <form action="{{ route('orders.index') }}" method="GET" class="row align-items-end g-3">
                        <div class="col-md-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">Start Date</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control {{ request('start_date') ? 'filter-active' : '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">End Date</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control {{ request('end_date') ? 'filter-active' : '' }}">
                        </div>
                        <div class="col-md-6 d-flex gap-2">
                            <button type="submit" class="btn btn-dark px-4 shadow-sm">
                                <i class="fas fa-search mr-1"></i> Apply
                            </button>
                            @if(request('start_date') || request('end_date'))
                            <a href="{{ route('orders.index') }}" class="btn btn-light border px-4">
                                <i class="fas fa-times mr-1"></i> Clear
                            </a>
                            @endif
                            
                            <!-- DOWNLOAD BUTTON -->
                            <a href="{{ route('orders.download') }}?{{ http_build_query(request()->only(['start_date', 'end_date'])) }}" 
                               class="btn btn-outline-primary px-4 ml-auto" target="_blank">
                                <i class="fas fa-file-pdf mr-1"></i> Export PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ==================== STATS ROW ==================== -->
            <div class="row mb-4">
                <!-- Dynamic Stat -->
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="card stats-card bg-gradient-primary h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stats-icon mr-3">
                                <i class="fas fa-{{ request('start_date') ? 'filter' : 'calendar-day' }}"></i>
                            </div>
                            <div>
                                <span class="small text-white-50 text-uppercase fw-bold">
                                    {{ request('start_date') ? 'Selected Period' : 'Today' }}
                                </span>
                                <h2 class="mb-0 font-weight-bold text-white">Ksh {{ number_format($todaySales, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Week Sales -->
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="card stats-card bg-gradient-success h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stats-icon mr-3">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                            <div>
                                <span class="small text-white-50 text-uppercase fw-bold">This Week</span>
                                <h2 class="mb-0 font-weight-bold text-white">Ksh {{ number_format($weekSales, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Month Sales -->
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="card stats-card bg-gradient-info h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stats-icon mr-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <span class="small text-white-50 text-uppercase fw-bold">This Month</span>
                                <h2 class="mb-0 font-weight-bold text-white">Ksh {{ number_format($monthSales, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== ORDERS TABLE ==================== -->
            <div class="table-container border-0 shadow-sm">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 section-title">
                        @if(request('start_date') || request('end_date'))
                            Results: <span class="text-primary">{{ request('start_date') ?? 'Start' }}</span> to <span class="text-primary">{{ request('end_date') ?? 'Now' }}</span>
                        @else
                            Recent Orders
                        @endif
                    </h5>
                    <span class="badge bg-light text-dark border">{{ $orders->total() }} Records</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <span class="fw-bold text-dark">{{ $order->invoice_no }}</span>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $order->customer_name ?? 'Walk-in' }}</span>
                                </td>
                                <td class="fw-bold">Ksh {{ number_format($order->total_amount, 2) }}</td>
                                
                                <!-- STATUS DROPDOWN -->
                                <td>
                                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select status-select" onchange="this.form.submit()">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>

                                <td>
                                    @if($order->payment_status == 'paid')
                                        <span class="badge badge-status bg-success text-white">Paid</span>
                                    @elseif($order->payment_status == 'partial')
                                        <span class="badge badge-status bg-warning text-dark">Partial</span>
                                    @else
                                        <span class="badge badge-status bg-danger text-white">Unpaid</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <span class="text-muted">{{ $order->created_at->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pos.receipt', $order->id) }}" 
                                       class="btn btn-receipt" 
                                       target="_blank">
                                        <i class="fas fa-print mr-1"></i> Receipt
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No Orders Found</h5>
                                        <p class="text-muted small mb-0">Try adjusting your date filters.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Links -->
            @if($orders->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $orders->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    @endsection
</x-layout>