@extends('components.layout')

@section('title', 'Online Orders')

@push('styles')
<style>
    :root {
        --brand: #16a34a;
        --brand-dark: #15803d;
        --brand-light: #ecfdf3;
        --ink: #0f172a;
        --muted: #64748b;
        --line: #eef1f5;
    }

    .oo-header {
        background: linear-gradient(135deg, #14532d 0%, #16a34a 60%, #22c55e 100%);
        border-radius: 20px;
        padding: 28px 32px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 30px -12px rgba(22, 163, 74, .45);
    }
    .oo-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 85% -10%, rgba(255,255,255,.18), transparent 55%);
        pointer-events: none;
    }
    .oo-header h4 { font-weight: 700; letter-spacing: -.01em; }
    .oo-header p { color: rgba(255,255,255,.8); }
    .oo-badge-count {
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.3);
        backdrop-filter: blur(6px);
        font-weight: 600;
        padding: .55rem 1.1rem;
        border-radius: 999px;
    }

    .stat-card {
        border: 1px solid var(--line);
        border-radius: 16px;
        background: #fff;
        transition: transform .18s ease, box-shadow .18s ease;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 14px 28px -16px rgba(15, 23, 42, .18); }
    .stat-card .stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem;
    }
    .stat-card .stat-value { font-size: 1.9rem; font-weight: 700; letter-spacing: -.02em; color: var(--ink); }
    .stat-card .stat-label { font-size: .8rem; text-transform: uppercase; letter-spacing: .04em; color: var(--muted); font-weight: 600; }
    .stat-card.accent-total::before,
    .stat-card.accent-pending::before,
    .stat-card.accent-processing::before,
    .stat-card.accent-completed::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    }
    .stat-card.accent-total::before { background: linear-gradient(90deg, #16a34a, #22c55e); }
    .stat-card.accent-pending::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.accent-processing::before { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
    .stat-card.accent-completed::before { background: linear-gradient(90deg, #16a34a, #4ade80); }

    .oo-toolbar {
        border: 1px solid var(--line);
        border-radius: 16px;
        background: #fff;
    }
    .oo-toolbar .form-control:focus,
    .oo-toolbar .form-select:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 .2rem rgba(22, 163, 74, .12);
    }
    .btn-brand-outline {
        border: 1px solid var(--brand);
        color: var(--brand-dark);
        font-weight: 600;
        background: #fff;
    }
    .btn-brand-outline:hover { background: var(--brand-light); color: var(--brand-dark); }

    .oo-table-card { border: 1px solid var(--line); border-radius: 16px; overflow: hidden; }
    .oo-table-card .card-header { background: #fff; border-bottom: 1px solid var(--line); }

    table.oo-table thead th {
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        font-size: .74rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--muted);
        font-weight: 700;
        padding: .9rem .85rem;
        white-space: nowrap;
    }
    table.oo-table tbody td { padding: .95rem .85rem; vertical-align: middle; border-bottom: 1px solid var(--line); }
    table.oo-table tbody tr { transition: background .15s ease; }
    table.oo-table tbody tr:hover { background: #f8fdf9; }
    table.oo-table tbody tr:last-child td { border-bottom: none; }

    .avatar-chip {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff; font-weight: 700; font-size: .85rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .order-id { font-weight: 700; color: var(--brand-dark); letter-spacing: -.01em; }

    .pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: .32rem .7rem; border-radius: 999px;
        font-size: .74rem; font-weight: 700; letter-spacing: .01em;
        border: 1px solid transparent;
    }
    .pill-pending    { background: #fffbeb; color: #b45309; border-color: #fde68a; }
    .pill-processing { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .pill-ready      { background: #eef2ff; color: #4338ca; border-color: #c7d2fe; }
    .pill-completed,
    .pill-delivered  { background: #ecfdf3; color: #15803d; border-color: #bbf7d0; }
    .pill-cancelled  { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }
    .pill-paid       { background: #ecfdf3; color: #15803d; border-color: #bbf7d0; }
    .pill-failed     { background: #fef2f2; color: #b91c1c; border-color: #fecaca; }

    .amount-tag { font-weight: 700; color: var(--ink); }

    .btn-view {
        width: 34px; height: 34px; border-radius: 9px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid var(--line); color: var(--brand-dark);
        background: #fff; transition: all .15s ease;
    }
    .btn-view:hover { background: var(--brand); color: #fff; border-color: var(--brand); }

    .empty-state { padding: 4rem 1rem; text-align: center; }
    .empty-state i { font-size: 3rem; color: #cbd5e1; }
</style>
@endpush

@section('content')

<div class="container-fluid px-0">

    {{-- HEADER --}}
    <div class="oo-header mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div style="position: relative; z-index: 1;">
            <h4 class="mb-1"><i class="bi bi-bag-check me-2"></i>Online Orders</h4>
            <p class="mb-0">Manage orders submitted through the online ordering system.</p>
        </div>
        <span class="oo-badge-count" style="position: relative; z-index: 1;">
            {{ $counts['total'] ?? 0 }} {{ Str::plural('Order', $counts['total'] ?? 0) }}
        </span>
    </div>

    {{-- MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- SUMMARY CARDS --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="stat-card accent-total p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-2">Total Orders</div>
                        <div class="stat-value">{{ $counts['total'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon" style="background: var(--brand-light); color: var(--brand-dark);">
                        <i class="bi bi-bag-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card accent-pending p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-2">Pending</div>
                        <div class="stat-value">{{ $counts['pending'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon" style="background: #fffbeb; color: #b45309;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card accent-processing p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-2">Processing</div>
                        <div class="stat-value">{{ $counts['processing'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon" style="background: #eff6ff; color: #1d4ed8;">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="stat-card accent-completed p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-2">Completed</div>
                        <div class="stat-value">{{ $counts['completed'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon" style="background: var(--brand-light); color: var(--brand-dark);">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- SEARCH AND FILTER --}}
    <div class="oo-toolbar p-3 mb-4">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-semibold small text-muted">Search Orders</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="orderSearch" class="form-control border-start-0 ps-0"
                           placeholder="Search customer, phone, email or order number...">
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold small text-muted">Order Status</label>
                <select id="statusFilter" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="ready">Ready</option>
                    <option value="completed">Completed</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-brand-outline w-100" onclick="window.location.reload()">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
            </div>

        </div>
    </div>

    {{-- ORDERS TABLE --}}
    <div class="oo-table-card">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0"><i class="bi bi-list-ul me-2" style="color: var(--brand);"></i>Online Orders List</h6>
            <span class="text-muted small">Latest orders first</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table oo-table align-middle mb-0" id="ordersTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Order</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Service</th>
                            <th>Pickup / Delivery</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center pe-4">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            @php $initials = collect(explode(' ', $order->customer_name))->map(fn($n) => strtoupper($n[0] ?? ''))->take(2)->implode(''); @endphp
                            <tr class="order-row"
                                data-search="{{ strtolower(
                                    $order->order_number . ' ' .
                                    $order->customer_name . ' ' .
                                    $order->phone . ' ' .
                                    ($order->email ?? '')
                                ) }}"
                                data-status="{{ strtolower($order->status) }}">

                                <td class="ps-4">
                                    <div class="order-id">#{{ $order->order_number }}</div>
                                    <small class="text-muted">Online Order</small>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-chip">{{ $initials ?: '—' }}</div>
                                        <div class="fw-semibold">{{ $order->customer_name }}</div>
                                    </div>
                                </td>

                                <td>
                                    <div class="small"><i class="bi bi-telephone me-1 text-muted"></i>{{ $order->phone }}</div>
                                    @if($order->email)
                                        <div class="small text-muted"><i class="bi bi-envelope me-1"></i>{{ $order->email }}</div>
                                    @endif
                                </td>

                                <td>
                                    <div class="fw-semibold small">{{ $order->service_name }}</div>
                                    <div class="small text-muted">Qty: {{ rtrim(rtrim($order->quantity, '0'), '.') }}</div>
                                </td>

                                <td>
                                    <div class="small"><i class="bi bi-calendar-event me-1 text-muted"></i>{{ $order->pickup_date->format('d M Y') }}</div>
                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($order->pickup_time)->format('g:i A') }}</div>
                                    <div class="small text-muted mt-1"><i class="bi bi-geo-alt me-1"></i>{{ \Illuminate\Support\Str::limit($order->delivery_address, 28) }}</div>
                                </td>

                                <td><span class="amount-tag">KSh {{ number_format($order->total_amount, 2) }}</span></td>

                                <td>
                                    @php $paymentStatus = strtolower($order->payment_status); @endphp
                                    @if($paymentStatus === 'paid')
                                        <span class="pill pill-paid"><i class="bi bi-check-circle"></i> Paid</span>
                                    @elseif($paymentStatus === 'failed')
                                        <span class="pill pill-failed"><i class="bi bi-x-circle"></i> Failed</span>
                                    @else
                                        <span class="pill pill-pending"><i class="bi bi-clock"></i> Pending</span>
                                    @endif
                                </td>

                                <td>
                                    @php
                                        $status = strtolower($order->status);
                                        $statusIcons = [
                                            'pending' => 'bi-clock',
                                            'processing' => 'bi-arrow-repeat',
                                            'ready' => 'bi-check2',
                                            'completed' => 'bi-check-circle',
                                            'delivered' => 'bi-truck',
                                            'cancelled' => 'bi-x-circle',
                                        ];
                                        $statusIcon = $statusIcons[$status] ?? 'bi-info-circle';
                                    @endphp
                                    <span class="pill pill-{{ $status }}">
                                        <i class="bi {{ $statusIcon }}"></i> {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="small">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="small text-muted">{{ $order->created_at->format('h:i A') }}</div>
                                </td>

                                <td class="text-center pe-4">
                                    <a href="{{ route('online-orders.show', $order->id) }}" class="btn-view" title="View Order">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="empty-state">
                                        <i class="bi bi-bag-x d-block mb-3"></i>
                                        <h6 class="fw-bold">No Online Orders Found</h6>
                                        <p class="text-muted mb-0">Online orders will appear here when customers place them.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        @if($orders->hasPages())
            <div class="card-footer bg-white border-top" style="border-color: var(--line) !important;">
                {{ $orders->links() }}
            </div>
        @endif

    </div>

</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('orderSearch');
    const statusFilter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('.order-row');

    function filterOrders() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedStatus = statusFilter.value.toLowerCase();

        rows.forEach(function (row) {
            const searchableText = row.getAttribute('data-search') || '';
            const rowStatus = row.getAttribute('data-status') || '';
            const matchesSearch = searchableText.includes(searchTerm);
            const matchesStatus = !selectedStatus || rowStatus === selectedStatus;
            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterOrders);
    statusFilter.addEventListener('change', filterOrders);
});
</script>
@endpush

@endsection