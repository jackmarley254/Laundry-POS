<x-layout>
    @section('title', 'Dashboard Overview')

    @section('content')
        <!-- Modern Dashboard Styles -->
        <style>
            body {
                background-color: #f0f2f5;
            }

            .modern-card {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                overflow: hidden;
                position: relative;
            }

            .modern-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            /* Decorative background circle for cards */
            .stat-card::before {
                content: "";
                position: absolute;
                top: -20%;
                right: -20%;
                width: 150px;
                height: 150px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.15);
                z-index: 0;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(5px);
                z-index: 1;
            }

            /* Gradients */
            .bg-gradient-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .bg-gradient-success {
                background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            }

            .bg-gradient-warning {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            }

            .bg-gradient-info {
                background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            }

            .content-card {
                background: #ffffff;
                border: none;
                border-radius: 1rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            }

            .content-card .card-header {
                background: transparent;
                border-bottom: 1px solid #f1f1f1;
                padding: 1.25rem 1.5rem;
            }

            .content-card .card-title {
                font-weight: 700;
                color: #333;
                font-size: 1rem;
                margin: 0;
            }

            /* Table Styling */
            .modern-table thead th {
                background-color: #f8f9fa;
                color: #6c757d;
                font-weight: 700;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-bottom: 2px solid #e9ecef;
                padding: 1rem;
            }

            .modern-table tbody tr {
                transition: background 0.2s;
            }

            .modern-table tbody tr:hover {
                background-color: rgba(102, 126, 234, 0.05);
            }

            .btn-action {
                padding: 0.75rem 1.5rem;
                border-radius: 0.8rem;
                font-weight: 600;
                font-size: 0.9rem;
                transition: all 0.2s;
            }

            /* Top Action Bar Styles */
            .top-action-bar {
                background: #ffffff;
                border-radius: 1rem;
                padding: 1.25rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
            }

            .top-action-bar .btn {
                flex-grow: 1;
                text-align: center;
                border-radius: 0.6rem;
                font-weight: 600;
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
            }

            @media (max-width: 768px) {
                .top-action-bar .btn {
                    flex-grow: 0 0 48%;
                }
            }
        </style>

        <div class="container-fluid mt-4">

            <!-- ==================== TOP ACTION BUTTONS ==================== -->
            <div class="top-action-bar">
                <a href="{{ route('pos.index') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle mr-1"></i> Make New Order
                </a>
                <a href="{{ route('orders.index', ['filter' => 'today']) }}" class="btn btn-outline-primary">
                    <i class="bi bi-calendar-day mr-1"></i> View Today's Orders
                </a>
                <a href="{{ route('orders.index', ['filter' => 'pending']) }}" class="btn btn-outline-warning text-warning">
                    <i class="bi bi-hourglass-split mr-1"></i> View Pending Orders
                </a>
                <a href="{{ route('orders.index', ['filter' => 'completed']) }}"
                    class="btn btn-outline-success text-success">
                    <i class="bi bi-check-circle mr-1"></i> View Completed Orders
                </a>
                <a href="{{ route('sales.monthly') }}" class="btn btn-outline-info text-info">
                    <i class="bi bi-graph-up mr-1"></i> View All Sales (Month)
                </a>
            </div>

            <!-- ==================== STATS ROW ==================== -->
            <div class="row mb-4">
                <!-- Card 1: Today's Sales (Ksh Logic Applied) -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 modern-card stat-card bg-gradient-primary text-white">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon text-white me-3">
                                <i class="bi bi-currency-dollar fa-2x"></i>
                            </div>
                            <div class="position-relative z-index-1">
                                <span class="text-white-50 text-uppercase small">Today's Sales</span>
                                <h3 class="mb-0 font-weight-bold mt-1">
                                    Ksh {{ number_format($todaySales, 2) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Today's Orders -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 modern-card stat-card bg-gradient-success text-white">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon text-white me-3">
                                <i class="bi bi-bag-check fa-2x"></i>
                            </div>
                            <div class="position-relative z-index-1">
                                <span class="text-white-50 text-uppercase small">Today's Orders</span>
                                <h3 class="mb-0 font-weight-bold mt-1">{{ $totalOrders }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Pending Orders (Issued Status Logic Visualized) -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 modern-card stat-card bg-gradient-warning text-white">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon text-white me-3">
                                <i class="bi bi-hourglass-split fa-2x"></i>
                            </div>
                            <div class="position-relative z-index-1">
                                <span class="text-white-50 text-uppercase small">Pending Processing</span>
                                <h3 class="mb-0 font-weight-bold mt-1">{{ $pendingOrders }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Ready for Pickup -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 modern-card stat-card bg-gradient-info text-white">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon text-white me-3">
                                <i class="bi bi-bell fa-2x"></i>
                            </div>
                            <div class="position-relative z-index-1">
                                <span class="text-white-50 text-uppercase small">Ready for Pickup</span>
                                <h3 class="mb-0 font-weight-bold mt-1">{{ $readyOrders }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== CHARTS & ACTIONS ROW ==================== -->
            <div class="row mb-4">
                <!-- Sales Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card content-card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="card-title"><i class="fas fa-chart-line mr-2 text-primary"></i> Earnings Overview
                                (Last 7 Days)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart" height="120"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card content-card h-100">
                        <div class="card-header py-3">
                            <h6 class="card-title"><i class="fas fa-bolt mr-2 text-warning"></i> Quick Actions</h6>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <a href="{{ route('pos.index') }}" class="btn btn-action btn-primary mb-3 shadow-sm">
                                <i class="bi bi-plus-circle mr-2"></i> Create New Order
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-action btn-outline-secondary">
                                <i class="bi bi-list-ul mr-2"></i> View All Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== RECENT ORDERS TABLE ==================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card content-card">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="card-title"><i class="fas fa-history mr-2 text-info"></i> Recent Orders</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover modern-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                            <tr>
                                                <td><strong>{{ $order->invoice_no }}</strong></td>
                                                <td>{{ $order->customer_name }}</td>
                                                <!-- Updated to Ksh -->
                                                <td>Ksh {{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    @php
                                                        // Logic: Delivered (Green), Pending (Blue), Others (Teal)
                                                        $status_class =
                                                            $order->status == 'delivered'
                                                                ? 'success'
                                                                : ($order->status == 'pending'
                                                                    ? 'primary'
                                                                    : 'info');
                                                    @endphp

                                                    @if ($order->status == 'pending')
                                                        <!-- Force Blue Button with White Text for Visibility -->
                                                        <span class="badge badge-pill px-3 py-1"
                                                            style="background-color: #0d6efd; color: #ffffff; font-size: 0.85rem; font-weight: 600;">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    @else
                                                        <!-- Standard badges for other statuses -->
                                                        <span class="badge badge-pill badge-{{ $status_class }} px-3 py-1">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                                <td>
                                                    <a href="{{ route('pos.receipt', $order->id) }}"
                                                        class="btn btn-sm btn-light text-primary border" target="_blank">
                                                        <i class="fas fa-receipt mr-1"></i> Receipt
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-5">
                                                    <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                                    No recent orders found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <!-- Chart.js Library -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            // Sales Chart Logic
            const ctx = document.getElementById('salesChart').getContext('2d');

            // Prepare PHP data for JS
            const labels = {!! json_encode(array_keys($salesData->toArray())) !!};
            const data = {!! json_encode(array_values($salesData->toArray())) !!};

            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales (Ksh)',
                        data: data,
                        backgroundColor: "rgba(102, 126, 234, 0.1)",
                        borderColor: "rgba(102, 126, 234, 1)",
                        pointBackgroundColor: "#fff",
                        pointBorderColor: "rgba(102, 126, 234, 1)",
                        pointHoverBackgroundColor: "rgba(102, 126, 234, 1)",
                        pointHoverBorderColor: "#fff",
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBorderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: "#f1f1f1",
                                drawBorder: false,
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Ksh ' + value.toLocaleString();
                                },
                                font: {
                                    family: "'Segoe UI', sans-serif"
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#333',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 12
                            },
                            callbacks: {
                                label: function(context) {
                                    return 'Ksh ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-layout>
