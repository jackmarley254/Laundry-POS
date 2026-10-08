
@extends('components.layout')

@section('title', 'Order Details')

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

    .od-page {
        color: var(--ink);
    }

    /* ============================================================
       HEADER
    ============================================================ */

    .od-header {
        background: linear-gradient(
            135deg,
            #14532d 0%,
            #16a34a 60%,
            #22c55e 100%
        );
        border-radius: 20px;
        padding: 28px 32px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 12px 30px -12px rgba(22, 163, 74, .45);
    }

    .od-header::before {
        content: '';
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        right: -90px;
        top: -140px;
        background: rgba(255,255,255,.08);
    }

    .od-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(
                circle at 85% -10%,
                rgba(255,255,255,.18),
                transparent 55%
            );
        pointer-events: none;
    }

    .od-header-content {
        position: relative;
        z-index: 2;
    }

    .od-header h4 {
        font-weight: 700;
        letter-spacing: -.01em;
    }

    .od-header p {
        color: rgba(255,255,255,.8);
    }

    .od-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #fff;
        border: 1px solid rgba(255,255,255,.28);
        background: rgba(255,255,255,.10);
        padding: .65rem 1rem;
        border-radius: 10px;
        text-decoration: none;
        font-size: .85rem;
        font-weight: 600;
        transition: all .18s ease;
        backdrop-filter: blur(8px);
    }

    .od-back-btn:hover {
        color: #fff;
        background: rgba(255,255,255,.18);
        border-color: rgba(255,255,255,.45);
    }

    /* ============================================================
       ORDER NUMBER BADGE
    ============================================================ */

    .order-number-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: .45rem .85rem;
        border-radius: 999px;
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.25);
        color: #fff;
        font-size: .76rem;
        font-weight: 700;
        letter-spacing: .02em;
    }

    /* ============================================================
       CARDS
    ============================================================ */

    .od-card {
        border: 1px solid var(--line);
        border-radius: 16px;
        background: #fff;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15,23,42,.025);
    }

    .od-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--line);
        background: #fff;
    }

    .od-card-header h6 {
        font-weight: 700;
        margin: 0;
    }

    .od-card-header p {
        margin: 3px 0 0;
        color: var(--muted);
        font-size: .78rem;
    }

    .od-card-body {
        padding: 20px;
    }

    /* ============================================================
       SECTION ICONS
    ============================================================ */

    .section-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1rem;
    }

    .section-icon.green {
        background: var(--brand-light);
        color: var(--brand-dark);
    }

    .section-icon.blue {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .section-icon.orange {
        background: #fff7ed;
        color: #c2410c;
    }

    .section-icon.purple {
        background: #f5f3ff;
        color: #6d28d9;
    }

    /* ============================================================
       STATUS PANEL
    ============================================================ */

    .status-panel {
        border: 1px solid var(--line);
        border-radius: 16px;
        background: #fff;
        padding: 18px 20px;
        box-shadow: 0 2px 8px rgba(15,23,42,.025);
    }

    .status-label {
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--muted);
        font-weight: 700;
    }

    .status-current {
        font-size: 1rem;
        font-weight: 700;
        margin-top: 3px;
    }

    .status-form .form-select {
        min-width: 155px;
        border-radius: 10px;
        border-color: var(--line);
        font-size: .84rem;
        font-weight: 600;
    }

    .status-form .form-select:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 .2rem rgba(22,163,74,.12);
    }

    .btn-brand {
        border: 1px solid var(--brand);
        background: var(--brand);
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: .58rem 1rem;
        font-size: .82rem;
        transition: all .15s ease;
    }

    .btn-brand:hover {
        background: var(--brand-dark);
        border-color: var(--brand-dark);
        color: #fff;
    }

    /* ============================================================
       INFORMATION ROWS
    ============================================================ */

    .info-item {
        padding: 13px 0;
        border-bottom: 1px solid var(--line);
    }

    .info-item:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .info-label {
        font-size: .68rem;
        text-transform: uppercase;
        letter-spacing: .045em;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: .9rem;
        color: var(--ink);
        font-weight: 600;
    }

    .info-value.muted {
        color: var(--muted);
        font-weight: 500;
    }

    .phone-link {
        color: var(--brand-dark);
        text-decoration: none;
    }

    .phone-link:hover {
        color: var(--brand);
        text-decoration: underline;
    }

    /* ============================================================
       AVATAR
    ============================================================ */

    .customer-avatar {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
        font-size: 1rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 16px -8px rgba(22,163,74,.55);
        flex-shrink: 0;
    }

    /* ============================================================
       TABLE
    ============================================================ */

    .od-table {
        margin: 0;
    }

    .od-table thead th {
        background: #f8fafc;
        border-bottom: 1px solid var(--line);
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--muted);
        font-weight: 700;
        padding: .85rem .85rem;
        white-space: nowrap;
    }

    .od-table tbody td {
        padding: .95rem .85rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--line);
    }

    .od-table tbody tr:last-child td {
        border-bottom: none;
    }

    .od-table tbody tr:hover {
        background: #f8fdf9;
    }

    .service-name {
        font-weight: 700;
        color: var(--ink);
        font-size: .86rem;
    }

    .service-code {
        font-size: .72rem;
        color: var(--muted);
        margin-top: 2px;
    }

    .amount-tag {
        font-weight: 700;
        color: var(--ink);
    }

    /* ============================================================
       PILLS
    ============================================================ */

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: .32rem .7rem;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .01em;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .pill-pending {
        background: #fffbeb;
        color: #b45309;
        border-color: #fde68a;
    }

    .pill-processing {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .pill-ready {
        background: #eef2ff;
        color: #4338ca;
        border-color: #c7d2fe;
    }

    .pill-completed,
    .pill-delivered,
    .pill-paid {
        background: #ecfdf3;
        color: #15803d;
        border-color: #bbf7d0;
    }

    .pill-cancelled,
    .pill-failed {
        background: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    /* ============================================================
       TOTAL
    ============================================================ */

    .total-box {
        background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        border: 1px solid #bbf7d0;
        border-radius: 13px;
        padding: 16px;
    }

    .total-label {
        color: var(--muted);
        font-size: .76rem;
        font-weight: 600;
    }

    .total-value {
        color: var(--brand-dark);
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.02em;
    }

    /* ============================================================
       TIMELINE
    ============================================================ */

    .timeline {
        position: relative;
        padding-left: 8px;
    }

    .timeline-item {
        position: relative;
        display: flex;
        gap: 13px;
        padding-bottom: 22px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 6px;
        top: 16px;
        bottom: 0;
        width: 1px;
        background: #e2e8f0;
    }

    .timeline-dot {
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: var(--brand);
        border: 3px solid #dcfce7;
        position: relative;
        z-index: 2;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .timeline-dot.muted {
        background: #94a3b8;
        border-color: #f1f5f9;
    }

    .timeline-title {
        font-size: .82rem;
        font-weight: 700;
        color: var(--ink);
    }

    .timeline-date {
        color: var(--muted);
        font-size: .72rem;
        margin-top: 2px;
    }

    /* ============================================================
       NOTES
    ============================================================ */

    .notes-box {
        background: #f8fafc;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 14px 15px;
        color: #475569;
        font-size: .84rem;
        line-height: 1.65;
    }

    /* ============================================================
       QUICK ACTIONS
    ============================================================ */

    .quick-action {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 11px 12px;
        border: 1px solid var(--line);
        border-radius: 11px;
        text-decoration: none;
        color: var(--ink);
        transition: all .15s ease;
    }

    .quick-action:hover {
        border-color: #bbf7d0;
        background: #f8fdf9;
        color: var(--brand-dark);
    }

    .quick-action i {
        color: var(--brand);
        font-size: 1rem;
    }

    .quick-action span {
        font-size: .8rem;
        font-weight: 600;
    }

    /* ============================================================
       RESPONSIVE
    ============================================================ */

    @media (max-width: 767.98px) {
        .od-header {
            padding: 22px 20px;
            border-radius: 16px;
        }

        .od-card-body {
            padding: 16px;
        }

        .od-card-header {
            padding: 16px;
        }

        .status-form {
            width: 100%;
        }

        .status-form .form-select {
            flex: 1;
        }
    }
</style>
@endpush

@section('content')

@php
    $status = strtolower($order->status ?? 'pending');
    $paymentStatus = strtolower($order->payment_status ?? 'pending');

    $statusIcons = [
        'pending'    => 'bi-clock-history',
        'processing' => 'bi-arrow-repeat',
        'ready'      => 'bi-check2',
        'completed'  => 'bi-check-circle',
        'delivered'  => 'bi-truck',
        'cancelled'  => 'bi-x-circle',
    ];

    $statusIcon = $statusIcons[$status] ?? 'bi-info-circle';

    $initials = collect(
        preg_split('/\s+/', trim($order->customer_name ?? ''))
    )
    ->map(fn($name) => strtoupper(substr($name, 0, 1)))
    ->take(2)
    ->implode('');

    $statusLabel = ucfirst($status);
@endphp

<div class="container-fluid px-0 od-page">

    {{-- ============================================================
         HEADER
    ============================================================ --}}
    <div class="od-header mb-4">

        <div class="od-header-content">

            <div class="d-flex flex-wrap justify-content-between align-items-start gap-4">

                <div>
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">

                        <span class="order-number-badge">
                            <i class="bi bi-bag-check"></i>
                            #{{ $order->order_number }}
                        </span>

                        <span class="pill pill-{{ $status }}">
                            <i class="bi {{ $statusIcon }}"></i>
                            {{ $statusLabel }}
                        </span>

                    </div>

                    <h4 class="mb-1">
                        Order Details
                    </h4>

                    <p class="mb-0">
                        Review customer information, services, pickup details,
                        payment and order status.
                    </p>
                </div>

                <a href="{{ route('online-orders.index') }}"
                   class="od-back-btn">

                    <i class="bi bi-arrow-left"></i>

                    Back to Orders

                </a>

            </div>

        </div>
    </div>


    {{-- ============================================================
         FLASH MESSAGES
    ============================================================ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm"
             role="alert">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm"
             role="alert">

            <i class="bi bi-exclamation-triangle me-2"></i>

            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>
    @endif


    {{-- ============================================================
         STATUS UPDATE
    ============================================================ --}}
    <div class="status-panel mb-4">

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">

            <div class="d-flex align-items-center gap-3">

                <div class="section-icon green">
                    <i class="bi {{ $statusIcon }}"></i>
                </div>

                <div>
                    <div class="status-label">
                        Current Order Status
                    </div>

                    <div class="status-current">
                        {{ $statusLabel }}
                    </div>
                </div>

            </div>

            <form method="POST"
                  action="{{ route('online-orders.update-status', $order) }}"
                  class="status-form d-flex flex-column flex-sm-row gap-2">

                @csrf
                @method('PATCH')

                <select name="status"
                        class="form-select">

                    @foreach([
                        'pending'    => 'Pending',
                        'processing' => 'Processing',
                        'ready'      => 'Ready',
                        'completed'  => 'Completed',
                        'delivered'  => 'Delivered',
                        'cancelled'  => 'Cancelled',
                    ] as $value => $label)

                        <option value="{{ $value }}"
                            {{ $status === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

                <button type="submit"
                        class="btn btn-brand">

                    <i class="bi bi-check2 me-1"></i>

                    Update Status

                </button>

            </form>

        </div>

    </div>


    {{-- ============================================================
         MAIN CONTENT
    ============================================================ --}}
    <div class="row g-4">

        {{-- ========================================================
             LEFT COLUMN
        ========================================================= --}}
        <div class="col-xl-8">


            {{-- CUSTOMER INFORMATION --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon green">
                            <i class="bi bi-person"></i>
                        </div>

                        <div>
                            <h6>
                                Customer Information
                            </h6>

                            <p>
                                Customer contact and delivery information
                            </p>
                        </div>

                    </div>

                </div>


                <div class="od-card-body">

                    <div class="d-flex align-items-center gap-3 mb-4">

                        <div class="customer-avatar">
                            {{ $initials ?: '—' }}
                        </div>

                        <div>

                            <div class="fw-bold fs-6">
                                {{ $order->customer_name }}
                            </div>

                            <div class="small text-muted">
                                Online Customer
                            </div>

                        </div>

                    </div>


                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="info-item">

                                <div class="info-label">
                                    Phone Number
                                </div>

                                <div class="info-value">

                                    @if($order->phone)
                                        <a href="tel:{{ $order->phone }}"
                                           class="phone-link">

                                            <i class="bi bi-telephone me-1"></i>

                                            {{ $order->phone }}

                                        </a>
                                    @else
                                        <span class="muted">
                                            Not provided
                                        </span>
                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="info-item">

                                <div class="info-label">
                                    Email Address
                                </div>

                                <div class="info-value">

                                    @if($order->email)

                                        <a href="mailto:{{ $order->email }}"
                                           class="phone-link">

                                            <i class="bi bi-envelope me-1"></i>

                                            {{ $order->email }}

                                        </a>

                                    @else

                                        <span class="text-muted fw-normal">
                                            Not provided
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="col-12">

                            <div class="info-item">

                                <div class="info-label">
                                    Delivery Address
                                </div>

                                <div class="info-value">

                                    <i class="bi bi-geo-alt text-success me-1"></i>

                                    {{ $order->delivery_address ?: 'Not provided' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ORDER SERVICES --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center justify-content-between gap-3">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon blue">
                                <i class="bi bi-basket2"></i>
                            </div>

                            <div>
                                <h6>
                                    Order Services
                                </h6>

                                <p>
                                    Services included in this order
                                </p>
                            </div>

                        </div>

                        <span class="small text-muted">
                            {{ count($order->items ?? []) }}
                            {{ Str::plural('item', count($order->items ?? [])) }}
                        </span>

                    </div>

                </div>


                <div class="table-responsive">

                    <table class="table od-table align-middle">

                        <thead>

                            <tr>

                                <th class="ps-4">
                                    Service
                                </th>

                                <th>
                                    Unit
                                </th>

                                <th class="text-center">
                                    Qty
                                </th>

                                <th class="text-end">
                                    Price
                                </th>

                                <th class="text-end pe-4">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse(($order->items ?? []) as $item)

                                <tr>

                                    <td class="ps-4">

                                        <div class="service-name">
                                            {{ $item['name'] ?? 'Service' }}
                                        </div>

                                        @if(isset($item['service_id']))
                                            <div class="service-code">
                                                Service #{{ $item['service_id'] }}
                                            </div>
                                        @endif

                                    </td>


                                    <td>

                                        <span class="small text-muted">
                                            {{ $item['unit'] ?? 'Unit' }}
                                        </span>

                                    </td>


                                    <td class="text-center">

                                        <span class="fw-semibold">
                                            {{ $item['quantity'] ?? 1 }}
                                        </span>

                                    </td>


                                    <td class="text-end">

                                        <span class="small">
                                            KSh
                                            {{ number_format((float)($item['price'] ?? 0), 2) }}
                                        </span>

                                    </td>


                                    <td class="text-end pe-4">

                                        <span class="amount-tag">
                                            KSh
                                            {{ number_format((float)($item['subtotal'] ?? 0), 2) }}
                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="text-center py-5">

                                        <i class="bi bi-bag-x fs-2 text-muted"></i>

                                        <div class="fw-semibold mt-2">
                                            No individual service items found
                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="p-3 p-md-4 border-top">

                    <div class="total-box">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>

                                <div class="total-label">
                                    Order Total
                                </div>

                                <div class="small text-muted">
                                    Including all selected services
                                </div>

                            </div>

                            <div class="total-value">
                                KSh {{ number_format((float)$order->total_amount, 2) }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- CUSTOMER NOTES --}}
            @if($order->notes)

                <div class="od-card mb-4">

                    <div class="od-card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="section-icon orange">
                                <i class="bi bi-chat-left-text"></i>
                            </div>

                            <div>
                                <h6>
                                    Customer Notes
                                </h6>

                                <p>
                                    Additional instructions from the customer
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="od-card-body">

                        <div class="notes-box">
                            {{ $order->notes }}
                        </div>

                    </div>

                </div>

            @endif


        </div>


        {{-- ========================================================
             RIGHT COLUMN
        ========================================================= --}}
        <div class="col-xl-4">


            {{-- ORDER SUMMARY --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon green">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>
                            <h6>
                                Order Summary
                            </h6>

                            <p>
                                Key order information
                            </p>
                        </div>

                    </div>

                </div>


                <div class="od-card-body">

                    <div class="info-item">

                        <div class="info-label">
                            Order Number
                        </div>

                        <div class="info-value">
                            #{{ $order->order_number }}
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Service
                        </div>

                        <div class="info-value muted">
                            {{ $order->service_name }}
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Total Quantity
                        </div>

                        <div class="info-value">
                            {{ rtrim(rtrim((string)$order->quantity, '0'), '.') }}
                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Payment Status
                        </div>

                        <div class="info-value">

                            @if($paymentStatus === 'paid' || $paymentStatus === 'completed')

                                <span class="pill pill-paid">
                                    <i class="bi bi-check-circle"></i>
                                    Paid
                                </span>

                            @elseif($paymentStatus === 'failed')

                                <span class="pill pill-failed">
                                    <i class="bi bi-x-circle"></i>
                                    Failed
                                </span>

                            @else

                                <span class="pill pill-pending">
                                    <i class="bi bi-clock"></i>
                                    Pending
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="mt-4">

                        <div class="total-box">

                            <div class="total-label">
                                Total Amount
                            </div>

                            <div class="total-value">
                                KSh {{ number_format((float)$order->total_amount, 2) }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PICKUP / DELIVERY --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon blue">
                            <i class="bi bi-calendar-event"></i>
                        </div>

                        <div>
                            <h6>
                                Pickup & Delivery
                            </h6>

                            <p>
                                Customer's requested schedule
                            </p>
                        </div>

                    </div>

                </div>


                <div class="od-card-body">

                    <div class="info-item">

                        <div class="info-label">
                            Pickup Date
                        </div>

                        <div class="info-value">

                            @if($order->pickup_date)

                                <i class="bi bi-calendar3 text-primary me-1"></i>

                                {{ \Carbon\Carbon::parse($order->pickup_date)->format('D, d M Y') }}

                            @else
                                Not specified
                            @endif

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Pickup Time
                        </div>

                        <div class="info-value">

                            @if($order->pickup_time)

                                <i class="bi bi-clock text-primary me-1"></i>

                                {{ \Carbon\Carbon::parse($order->pickup_time)->format('g:i A') }}

                            @else
                                Not specified
                            @endif

                        </div>

                    </div>


                    <div class="info-item">

                        <div class="info-label">
                            Delivery Address
                        </div>

                        <div class="info-value muted">

                            <i class="bi bi-geo-alt text-danger me-1"></i>

                            {{ $order->delivery_address ?: 'Not provided' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- TIMELINE --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon purple">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <div>
                            <h6>
                                Order Timeline
                            </h6>

                            <p>
                                Order activity
                            </p>
                        </div>

                    </div>

                </div>


                <div class="od-card-body">

                    <div class="timeline">

                        <div class="timeline-item">

                            <div class="timeline-dot"></div>

                            <div>

                                <div class="timeline-title">
                                    Order Created
                                </div>

                                <div class="timeline-date">
                                    {{ $order->created_at?->format('d M Y, h:i A') }}
                                </div>

                            </div>

                        </div>


                        <div class="timeline-item">

                            <div class="timeline-dot {{ $status === 'pending' ? 'muted' : '' }}"></div>

                            <div>

                                <div class="timeline-title">
                                    Current Status
                                </div>

                                <div class="timeline-date">
                                    {{ $statusLabel }}
                                </div>

                            </div>

                        </div>


                        <div class="timeline-item">

                            <div class="timeline-dot muted"></div>

                            <div>

                                <div class="timeline-title">
                                    Last Updated
                                </div>

                                <div class="timeline-date">
                                    {{ $order->updated_at?->format('d M Y, h:i A') }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- QUICK ACTIONS --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="section-icon orange">
                            <i class="bi bi-lightning-charge"></i>
                        </div>

                        <div>
                            <h6>
                                Quick Actions
                            </h6>

                            <p>
                                Customer communication
                            </p>
                        </div>

                    </div>

                </div>


                <div class="od-card-body d-grid gap-2">

                    @if($order->phone)

                        <a href="tel:{{ $order->phone }}"
                           class="quick-action">

                            <i class="bi bi-telephone"></i>

                            <span>
                                Call Customer
                            </span>

                        </a>

                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $order->phone) }}"
                           target="_blank"
                           rel="noopener"
                           class="quick-action">

                            <i class="bi bi-whatsapp"></i>

                            <span>
                                WhatsApp Customer
                            </span>

                        </a>

                    @endif


                    @if($order->email)

                        <a href="mailto:{{ $order->email }}"
                           class="quick-action">

                            <i class="bi bi-envelope"></i>

                            <span>
                                Email Customer
                            </span>

                        </a>

                    @endif


                    <a href="{{ route('online-orders.index') }}"
                       class="quick-action">

                        <i class="bi bi-list-ul"></i>

                        <span>
                            View All Online Orders
                        </span>

                    </a>

                </div>

            </div>


        </div>

    </div>

</div>

@endsection

