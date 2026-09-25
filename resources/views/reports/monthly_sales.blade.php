<x-layout>
    @section('title', 'Monthly Sales Report')

    @section('content')
        <style>
            body { background-color: #f0f2f5; }
            .modern-card {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                overflow: hidden;
            }
            
            .stat-icon-lg {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(5px);
            }

            .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
            .bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
            
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
            
            .top-action-bar {
                background: #ffffff;
                border-radius: 1rem;
                padding: 1.25rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            }
        </style>

        <div class="container-fluid mt-4">
            <!-- Top Header -->
            <div class="top-action-bar d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-0 font-weight-bold">Monthly Sales Report</h3>
                    <span class="text-muted small">{{ now()->format('F Y') }}</span>
                </div>
                <a href="{{ route('pos.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left mr-1"></i> Back to Dashboard
                </a>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card modern-card bg-gradient-primary text-white h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon-lg text-white me-4">
                                <i class="bi bi-currency-dollar fa-2x"></i>
                            </div>
                            <div>
                                <span class="text-white-50 text-uppercase small">Total Revenue</span>
                                <h2 class="mb-0 font-weight-bold mt-1">Ksh {{ number_format($totalSales, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card modern-card bg-gradient-success text-white h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon-lg text-white me-4">
                                <i class="bi bi-bag-check fa-2x"></i>
                            </div>
                            <div>
                                <span class="text-white-50 text-uppercase small">Total Orders</span>
                                <h2 class="mb-0 font-weight-bold mt-1">{{ $totalOrders }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card content-card">
                        <div class="card-header py-3">
                            <h6 class="card-title"><i class="fas fa-chart-area mr-2 text-primary"></i> Daily Sales Trend</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlySalesChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card content-card">
                        <div class="card-header py-3">
                            <h6 class="card-title"><i class="fas fa-list mr-2 text-info"></i> Detailed Transactions</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover modern-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Invoice #</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($monthlyOrders as $order)
                                        <tr>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td><strong>{{ $order->invoice_no }}</strong></td>
                                            <td>{{ $order->customer->name ?? 'Walk-in' }}</td>
                                            <td>
                                                @php
                                                    $status_class = $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'primary' : 'warning');
                                                @endphp
                                                <span class="badge badge-pill badge-{{ $status_class }} px-3 py-1">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="text-right font-weight-bold">Ksh {{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-5">No sales recorded this month.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('monthlySalesChart').getContext('2d');
        
        // Prepare data from PHP
        const labels = {!! json_encode($dailySalesData->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M'); // Format date as "01 Jan"
        })) !!};
        
        const data = {!! json_encode($dailySalesData->pluck('total')) !!};

        const myChart = new Chart(ctx, {
            type: 'bar', // Bar chart looks good for daily breakdown
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily Sales (Ksh)',
                    data: data,
                    backgroundColor: "rgba(102, 126, 234, 0.6)",
                    borderColor: "rgba(102, 126, 234, 1)",
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: "#f1f1f1", drawBorder: false },
                        ticks: {
                            callback: function(value) { return 'Ksh ' + value.toLocaleString(); }
                        }
                    },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#333',
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