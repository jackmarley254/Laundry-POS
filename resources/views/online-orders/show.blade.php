@extends('components.layout')

@section('title', 'Order Details')

@push('styles')
<style>
    :root {
        --od-navy: #071A33;
        --od-navy-2: #0B2A4A;
        --od-blue: #0D6EFD;
        --od-blue-dark: #0B5ED7;
        --od-blue-soft: #EAF3FF;
        --od-blue-pale: #F5F9FF;

        --od-ink: #122033;
        --od-muted: #6B7A90;
        --od-muted-2: #94A3B8;
        --od-line: #E7EDF5;
        --od-surface: #F5F8FC;
        --od-white: #FFFFFF;

        --od-success: #15803D;
        --od-success-bg: #ECFDF3;
        --od-warning: #B45309;
        --od-warning-bg: #FFFBEB;
        --od-danger: #B91C1C;
        --od-danger-bg: #FEF2F2;
        --od-purple: #6D28D9;
        --od-purple-bg: #F5F3FF;

        --od-radius: 18px;
        --od-shadow: 0 8px 30px rgba(15, 23, 42, .055);
        --od-shadow-hover: 0 14px 36px rgba(15, 23, 42, .09);
    }

    .od-page {
        color: var(--od-ink);
        max-width: 1600px;
        margin: 0 auto;
    }

    /* ============================================================
       HERO
    ============================================================ */

    .od-hero {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        padding: 30px 32px;
        color: #fff;
        background:
            radial-gradient(circle at 90% 0%, rgba(255,255,255,.15), transparent 30%),
            linear-gradient(135deg, var(--od-navy) 0%, var(--od-navy-2) 48%, var(--od-blue) 100%);
        box-shadow: 0 18px 42px rgba(7, 26, 51, .18);
    }

    .od-hero::before {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        right: -130px;
        top: -190px;
        background: rgba(255,255,255,.08);
    }

    .od-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(135deg, rgba(255,255,255,.04) 25%, transparent 25%) 0 0 / 32px 32px;
        opacity: .35;
        pointer-events: none;
    }

    .od-hero-content {
        position: relative;
        z-index: 2;
    }

    .od-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 11px;
        border-radius: 999px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.18);
        color: rgba(255,255,255,.86);
        font-size: .69rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }

    .od-hero h1 {
        margin: 13px 0 7px;
        font-size: clamp(1.55rem, 2.5vw, 2.15rem);
        font-weight: 800;
        letter-spacing: -.035em;
    }

    .od-hero-description {
        max-width: 720px;
        margin: 0;
        color: rgba(255,255,255,.72);
        font-size: .88rem;
        line-height: 1.65;
    }

    .od-hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin-top: 18px;
    }

    .od-meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 9px;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.13);
        color: rgba(255,255,255,.8);
        font-size: .72rem;
        font-weight: 600;
    }

    .od-order-hero-card {
        min-width: 235px;
        padding: 18px;
        border-radius: 16px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.16);
        backdrop-filter: blur(12px);
    }

    .od-order-hero-label {
        color: rgba(255,255,255,.58);
        font-size: .67rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .od-order-number {
        margin-top: 4px;
        font-size: 1.2rem;
        font-weight: 800;
        letter-spacing: -.015em;
    }

    .od-order-hero-amount {
        margin-top: 12px;
        font-size: .76rem;
        color: rgba(255,255,255,.64);
    }

    .od-order-hero-amount strong {
        display: block;
        margin-top: 2px;
        color: #fff;
        font-size: 1.35rem;
    }

    .od-back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: .65rem 1rem;
        border-radius: 11px;
        color: #fff;
        text-decoration: none;
        background: rgba(255,255,255,.09);
        border: 1px solid rgba(255,255,255,.20);
        font-size: .78rem;
        font-weight: 700;
        transition: .2s ease;
        backdrop-filter: blur(10px);
    }

    .od-back-btn:hover {
        color: #fff;
        background: rgba(255,255,255,.17);
        border-color: rgba(255,255,255,.35);
        transform: translateY(-1px);
    }

    /* ============================================================
       FLASH MESSAGES
    ============================================================ */

    .od-alert {
        border-radius: 13px !important;
        padding: 13px 15px;
        font-size: .82rem;
    }

    /* ============================================================
       STATUS CONTROL
    ============================================================ */

    .od-status-panel {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 18px 20px;
        border: 1px solid var(--od-line);
        border-radius: var(--od-radius);
        background: #fff;
        box-shadow: var(--od-shadow);
    }

    .od-status-left {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .od-section-icon {
        width: 43px;
        height: 43px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 43px;
        border-radius: 12px;
        font-size: 1rem;
    }

    .od-icon-blue {
        background: var(--od-blue-soft);
        color: var(--od-blue);
    }

    .od-icon-navy {
        background: #E9F0F8;
        color: var(--od-navy);
    }

    .od-icon-warning {
        background: var(--od-warning-bg);
        color: var(--od-warning);
    }

    .od-icon-purple {
        background: var(--od-purple-bg);
        color: var(--od-purple);
    }

    .od-status-label {
        color: var(--od-muted);
        font-size: .65rem;
        font-weight: 800;
        letter-spacing: .07em;
        text-transform: uppercase;
    }

    .od-status-current {
        margin-top: 3px;
        font-size: .96rem;
        font-weight: 800;
    }

    .od-status-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .od-status-form .form-select {
        min-width: 165px;
        height: 42px;
        border-color: var(--od-line);
        border-radius: 10px;
        font-size: .78rem;
        font-weight: 700;
        color: var(--od-ink);
    }

    .od-status-form .form-select:focus {
        border-color: var(--od-blue);
        box-shadow: 0 0 0 .2rem rgba(13,110,253,.10);
    }

    .od-btn-primary {
        min-height: 42px;
        border: 0;
        border-radius: 10px;
        padding: .6rem 1rem;
        background: linear-gradient(135deg, var(--od-blue), var(--od-blue-dark));
        color: #fff;
        font-size: .78rem;
        font-weight: 750;
        box-shadow: 0 7px 16px rgba(13,110,253,.18);
        transition: .18s ease;
    }

    .od-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(13,110,253,.25);
    }

    /* ============================================================
       CARDS
    ============================================================ */

    .od-card {
        overflow: hidden;
        border: 1px solid var(--od-line);
        border-radius: var(--od-radius);
        background: #fff;
        box-shadow: var(--od-shadow);
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .od-card:hover {
        box-shadow: var(--od-shadow-hover);
    }

    .od-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--od-line);
        background: linear-gradient(180deg, #fff 0%, #FCFDFF 100%);
    }

    .od-card-body {
        padding: 20px;
    }

    .od-card-title {
        margin: 0;
        color: var(--od-ink);
        font-size: .88rem;
        font-weight: 800;
        letter-spacing: -.01em;
    }

    .od-card-subtitle {
        margin: 3px 0 0;
        color: var(--od-muted);
        font-size: .72rem;
        line-height: 1.5;
    }

    .od-card-count {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        border-radius: 8px;
        background: var(--od-blue-soft);
        color: var(--od-blue-dark);
        font-size: .68rem;
        font-weight: 800;
    }

    /* ============================================================
       CUSTOMER
    ============================================================ */

    .od-customer-profile {
        display: flex;
        align-items: center;
        gap: 13px;
        margin-bottom: 20px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--od-line);
    }

    .od-customer-avatar {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 55px;
        border-radius: 15px;
        background: linear-gradient(135deg, var(--od-navy), var(--od-blue));
        color: #fff;
        font-size: .98rem;
        font-weight: 850;
        box-shadow: 0 9px 20px rgba(13,110,253,.20);
    }

    .od-customer-name {
        font-size: .94rem;
        font-weight: 800;
    }

    .od-customer-type {
        margin-top: 2px;
        color: var(--od-muted);
        font-size: .72rem;
    }

    /* ============================================================
       INFO GRID
    ============================================================ */

    .od-info-item {
        min-height: 74px;
        padding: 13px 0;
        border-bottom: 1px solid var(--od-line);
    }

    .od-info-item.no-border {
        border-bottom: 0;
    }

    .od-info-label {
        margin-bottom: 5px;
        color: var(--od-muted-2);
        font-size: .64rem;
        font-weight: 800;
        letter-spacing: .065em;
        text-transform: uppercase;
    }

    .od-info-value {
        color: var(--od-ink);
        font-size: .83rem;
        font-weight: 700;
        line-height: 1.55;
    }

    .od-info-value.muted {
        color: var(--od-muted);
        font-weight: 550;
    }

    .od-contact-link {
        color: var(--od-blue-dark);
        text-decoration: none;
        font-weight: 700;
    }

    .od-contact-link:hover {
        color: var(--od-blue);
        text-decoration: underline;
    }

    .od-location {
        color: var(--od-ink);
    }

    /* ============================================================
       SERVICE TABLE
    ============================================================ */

    .od-table-wrap {
        overflow-x: auto;
    }

    .od-table {
        margin: 0;
        min-width: 650px;
    }

    .od-table thead th {
        padding: .8rem .85rem;
        border-bottom: 1px solid var(--od-line);
        background: #F7F9FC;
        color: var(--od-muted);
        font-size: .63rem;
        font-weight: 800;
        letter-spacing: .065em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .od-table tbody td {
        padding: .95rem .85rem;
        border-bottom: 1px solid var(--od-line);
        vertical-align: middle;
    }

    .od-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .od-table tbody tr {
        transition: background .15s ease;
    }

    .od-table tbody tr:hover {
        background: #F8FBFF;
    }

    .od-service-icon {
        width: 37px;
        height: 37px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--od-blue-soft);
        color: var(--od-blue);
        flex-shrink: 0;
    }

    .od-service-name {
        color: var(--od-ink);
        font-size: .81rem;
        font-weight: 800;
    }

    .od-service-code {
        margin-top: 2px;
        color: var(--od-muted);
        font-size: .65rem;
    }

    .od-unit-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 8px;
        border-radius: 7px;
        background: #F1F5F9;
        color: #475569;
        font-size: .65rem;
        font-weight: 700;
    }

    .od-quantity {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        padding: 5px 8px;
        border-radius: 7px;
        background: var(--od-blue-pale);
        color: var(--od-blue-dark);
        font-size: .72rem;
        font-weight: 800;
    }

    .od-price {
        color: var(--od-muted);
        font-size: .75rem;
        font-weight: 600;
    }

    .od-subtotal {
        color: var(--od-ink);
        font-size: .78rem;
        font-weight: 850;
    }

    /* ============================================================
       STATUS PILLS
    ============================================================ */

    .od-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 9px;
        border-radius: 999px;
        border: 1px solid transparent;
        font-size: .65rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .od-pill-pending {
        background: var(--od-warning-bg);
        border-color: #FDE68A;
        color: var(--od-warning);
    }

    .od-pill-processing {
        background: var(--od-blue-soft);
        border-color: #BFDBFE;
        color: #1D4ED8;
    }

    .od-pill-ready {
        background: #EEF2FF;
        border-color: #C7D2FE;
        color: #4338CA;
    }

    .od-pill-completed,
    .od-pill-delivered,
    .od-pill-paid {
        background: var(--od-success-bg);
        border-color: #BBF7D0;
        color: var(--od-success);
    }

    .od-pill-cancelled,
    .od-pill-failed {
        background: var(--od-danger-bg);
        border-color: #FECACA;
        color: var(--od-danger);
    }

    /* ============================================================
       TOTAL
    ============================================================ */

    .od-total-box {
        padding: 18px;
        border: 1px solid #CFE0FA;
        border-radius: 14px;
        background:
            radial-gradient(circle at 100% 0%, rgba(13,110,253,.08), transparent 40%),
            linear-gradient(135deg, #F5F9FF, #EEF6FF);
    }

    .od-total-label {
        color: var(--od-muted);
        font-size: .68rem;
        font-weight: 750;
    }

    .od-total-description {
        margin-top: 2px;
        color: var(--od-muted);
        font-size: .68rem;
    }

    .od-total-value {
        color: var(--od-blue-dark);
        font-size: 1.45rem;
        font-weight: 900;
        letter-spacing: -.035em;
        white-space: nowrap;
    }

    /* ============================================================
       NOTES
    ============================================================ */

    .od-notes {
        padding: 15px;
        border: 1px solid var(--od-line);
        border-radius: 12px;
        background: #F8FAFC;
        color: #475569;
        font-size: .8rem;
        line-height: 1.7;
    }

    /* ============================================================
       TIMELINE
    ============================================================ */

    .od-timeline {
        position: relative;
    }

    .od-timeline-item {
        position: relative;
        display: flex;
        gap: 13px;
        padding-bottom: 23px;
    }

    .od-timeline-item:last-child {
        padding-bottom: 0;
    }

    .od-timeline-item:not(:last-child)::before {
        content: "";
        position: absolute;
        left: 6px;
        top: 17px;
        bottom: 0;
        width: 1px;
        background: #DCE5F0;
    }

    .od-timeline-dot {
        position: relative;
        z-index: 2;
        width: 13px;
        height: 13px;
        margin-top: 2px;
        border-radius: 50%;
        flex: 0 0 13px;
        background: var(--od-blue);
        border: 3px solid #DDEBFF;
    }

    .od-timeline-dot.muted {
        background: #94A3B8;
        border-color: #EDF2F7;
    }

    .od-timeline-title {
        color: var(--od-ink);
        font-size: .78rem;
        font-weight: 800;
    }

    .od-timeline-date {
        margin-top: 2px;
        color: var(--od-muted);
        font-size: .67rem;
    }

    /* ============================================================
       QUICK ACTIONS
    ============================================================ */

    .od-quick-action {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 12px;
        border: 1px solid var(--od-line);
        border-radius: 11px;
        background: #fff;
        color: var(--od-ink);
        text-decoration: none;
        transition: .18s ease;
    }

    .od-quick-action:hover {
        color: var(--od-blue-dark);
        border-color: #BDD6FA;
        background: var(--od-blue-pale);
        transform: translateX(2px);
    }

    .od-quick-action-icon {
        width: 33px;
        height: 33px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: var(--od-blue-soft);
        color: var(--od-blue);
        flex-shrink: 0;
    }

    .od-quick-action span {
        font-size: .74rem;
        font-weight: 750;
    }

    /* ============================================================
       PAYMENT STATUS
    ============================================================ */

    .od-payment-card {
        padding: 14px;
        border: 1px solid var(--od-line);
        border-radius: 13px;
        background: #FBFDFF;
    }

    .od-payment-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .od-payment-label {
        color: var(--od-muted);
        font-size: .65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    /* ============================================================
       EMPTY SERVICES
    ============================================================ */

    .od-empty {
        padding: 50px 20px;
        text-align: center;
        color: var(--od-muted);
    }

    .od-empty-icon {
        width: 52px;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: var(--od-blue-soft);
        color: var(--od-blue);
        font-size: 1.3rem;
    }

    /* ============================================================
       RESPONSIVE
    ============================================================ */

    @media (max-width: 1199.98px) {
        .od-order-hero-card {
            min-width: 200px;
        }
    }

    @media (max-width: 767.98px) {
        .od-hero {
            padding: 22px 20px;
            border-radius: 17px;
        }

        .od-hero h1 {
            font-size: 1.55rem;
        }

        .od-order-hero-card {
            width: 100%;
            min-width: 0;
        }

        .od-status-panel {
            align-items: stretch;
            flex-direction: column;
            padding: 16px;
        }

        .od-status-form {
            width: 100%;
            flex-direction: column;
        }

        .od-status-form .form-select,
        .od-status-form .od-btn-primary {
            width: 100%;
        }

        .od-card-header,
        .od-card-body {
            padding: 16px;
        }

        .od-total-value {
            font-size: 1.15rem;
        }
    }

    @media (max-width: 480px) {
        .od-hero-meta {
            display: grid;
            grid-template-columns: 1fr;
        }

        .od-back-btn {
            width: 100%;
        }

        .od-customer-profile {
            align-items: flex-start;
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
        ->filter()
        ->map(fn ($name) => strtoupper(substr($name, 0, 1)))
        ->take(2)
        ->implode('');

    $statusLabel = ucfirst($status);

    $items = $order->items ?? [];
    $itemCount = count($items);

    $quantity = $order->quantity ?? 0;
    $quantityDisplay = rtrim(
        rtrim((string) $quantity, '0'),
        '.'
    );

    if ($quantityDisplay === '') {
        $quantityDisplay = '0';
    }

    $totalAmount = (float) ($order->total_amount ?? 0);

    $whatsappNumber = preg_replace('/\D/', '', $order->phone ?? '');
@endphp

<div class="container-fluid px-0 od-page">

    {{-- ============================================================
         HERO HEADER
    ============================================================ --}}
    <div class="od-hero mb-4">
        <div class="od-hero-content">

            <div class="d-flex flex-column flex-xl-row justify-content-between gap-4">

                <div class="flex-grow-1">

                    <div class="od-eyebrow">
                        <i class="bi bi-grid-1x2-fill"></i>
                        Online Order Management
                    </div>

                    <h1>Order Details</h1>

                    <p class="od-hero-description">
                        Review customer information, manage order progress,
                        monitor services, pickup scheduling, payment status
                        and fulfillment details from one place.
                    </p>

                    <div class="od-hero-meta">
                        <span class="od-meta-chip">
                            <i class="bi bi-shield-check"></i>
                            Order Control
                        </span>

                        <span class="od-meta-chip">
                            <i class="bi bi-clock-history"></i>
                            Live Order Record
                        </span>

                        <span class="od-meta-chip">
                            <i class="bi bi-wallet2"></i>
                            KSh {{ number_format($totalAmount, 2) }}
                        </span>
                    </div>

                </div>

                <div class="d-flex flex-column align-items-stretch gap-2">

                    <a href="{{ route('online-orders.index') }}"
                       class="od-back-btn">
                        <i class="bi bi-arrow-left"></i>
                        Back to Orders
                    </a>

                    <div class="od-order-hero-card">

                        <div class="od-order-hero-label">
                            Order Reference
                        </div>

                        <div class="od-order-number">
                            #{{ $order->order_number }}
                        </div>

                        <div class="od-order-hero-amount">
                            Total Order Value
                            <strong>
                                KSh {{ number_format($totalAmount, 2) }}
                            </strong>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>


    {{-- ============================================================
         FLASH MESSAGES
    ============================================================ --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show od-alert border-0 shadow-sm mb-4"
             role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show od-alert border-0 shadow-sm mb-4"
             role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
            </button>
        </div>
    @endif


    {{-- ============================================================
         STATUS MANAGEMENT
    ============================================================ --}}
    <div class="od-status-panel mb-4">

        <div class="od-status-left">

            <div class="od-section-icon od-icon-blue">
                <i class="bi {{ $statusIcon }}"></i>
            </div>

            <div>
                <div class="od-status-label">
                    Current Order Status
                </div>

                <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <div class="od-status-current">
                        {{ $statusLabel }}
                    </div>

                    <span class="od-pill od-pill-{{ $status }}">
                        <i class="bi {{ $statusIcon }}"></i>
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

        </div>

        <form method="POST"
              action="{{ route('online-orders.update-status', $order) }}"
              class="od-status-form">

            @csrf
            @method('PATCH')

            <select name="status"
                    class="form-select"
                    aria-label="Order status">

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
                    class="od-btn-primary">
                <i class="bi bi-check2-circle me-1"></i>
                Update Status
            </button>

        </form>

    </div>


    {{-- ============================================================
         MAIN CONTENT
    ============================================================ --}}
    <div class="row g-4">

        {{-- ========================================================
             LEFT COLUMN
        ========================================================= --}}
        <div class="col-xl-8">

            {{-- ====================================================
                 CUSTOMER INFORMATION
            ===================================================== --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="od-section-icon od-icon-blue">
                            <i class="bi bi-person-vcard"></i>
                        </div>

                        <div>
                            <h6 class="od-card-title">
                                Customer Information
                            </h6>

                            <p class="od-card-subtitle">
                                Customer contact and delivery information
                            </p>
                        </div>

                    </div>

                </div>

                <div class="od-card-body">

                    <div class="od-customer-profile">

                        <div class="od-customer-avatar">
                            {{ $initials ?: 'CU' }}
                        </div>

                        <div>
                            <div class="od-customer-name">
                                {{ $order->customer_name ?: 'Unnamed Customer' }}
                            </div>

                            <div class="od-customer-type">
                                <i class="bi bi-globe2 me-1"></i>
                                Online Customer
                            </div>
                        </div>

                    </div>

                    <div class="row g-4">

                        {{-- Phone --}}
                        <div class="col-md-6">

                            <div class="od-info-item">

                                <div class="od-info-label">
                                    Phone Number
                                </div>

                                <div class="od-info-value">

                                    @if($order->phone)

                                        <a href="tel:{{ $order->phone }}"
                                           class="od-contact-link">

                                            <i class="bi bi-telephone-fill me-1"></i>
                                            {{ $order->phone }}

                                        </a>

                                    @else

                                        <span class="text-muted fw-normal">
                                            Not provided
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">

                            <div class="od-info-item">

                                <div class="od-info-label">
                                    Email Address
                                </div>

                                <div class="od-info-value">

                                    @if($order->email)

                                        <a href="mailto:{{ $order->email }}"
                                           class="od-contact-link">

                                            <i class="bi bi-envelope-fill me-1"></i>
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

                        {{-- Address --}}
                        <div class="col-12">

                            <div class="od-info-item no-border">

                                <div class="od-info-label">
                                    Delivery Address
                                </div>

                                <div class="od-info-value od-location">

                                    <i class="bi bi-geo-alt-fill text-primary me-1"></i>

                                    {{ $order->delivery_address ?: 'Not provided' }}

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================
                 ORDER SERVICES
            ===================================================== --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center justify-content-between gap-3">

                        <div class="d-flex align-items-center gap-3">

                            <div class="od-section-icon od-icon-blue">
                                <i class="bi bi-basket2-fill"></i>
                            </div>

                            <div>
                                <h6 class="od-card-title">
                                    Order Services
                                </h6>

                                <p class="od-card-subtitle">
                                    Services included in this order
                                </p>
                            </div>

                        </div>

                        <span class="od-card-count">
                            {{ $itemCount }}
                            {{ $itemCount === 1 ? 'Item' : 'Items' }}
                        </span>

                    </div>

                </div>


                <div class="od-table-wrap">

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
                                    Quantity
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

                            @forelse($items as $item)

                                <tr>

                                    <td class="ps-4">

                                        <div class="d-flex align-items-center gap-2">

                                            <div class="od-service-icon">
                                                <i class="bi bi-droplet-half"></i>
                                            </div>

                                            <div>

                                                <div class="od-service-name">
                                                    {{ $item['name'] ?? 'Service' }}
                                                </div>

                                                @if(isset($item['service_id']))

                                                    <div class="od-service-code">
                                                        Service #{{ $item['service_id'] }}
                                                    </div>

                                                @endif

                                            </div>

                                        </div>

                                    </td>

                                    <td>

                                        <span class="od-unit-badge">
                                            {{ $item['unit'] ?? 'Unit' }}
                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <span class="od-quantity">
                                            {{ $item['quantity'] ?? 1 }}
                                        </span>

                                    </td>

                                    <td class="text-end">

                                        <span class="od-price">
                                            KSh
                                            {{ number_format((float) ($item['price'] ?? 0), 2) }}
                                        </span>

                                    </td>

                                    <td class="text-end pe-4">

                                        <span class="od-subtotal">
                                            KSh
                                            {{ number_format((float) ($item['subtotal'] ?? 0), 2) }}
                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5">

                                        <div class="od-empty">

                                            <div class="od-empty-icon">
                                                <i class="bi bi-bag-x"></i>
                                            </div>

                                            <div class="fw-bold mt-3">
                                                No individual service items
                                            </div>

                                            <div class="small mt-1">
                                                This order does not contain detailed service line items.
                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="p-3 p-md-4 border-top">

                    <div class="od-total-box">

                        <div class="d-flex align-items-center justify-content-between gap-3">

                            <div>

                                <div class="od-total-label">
                                    Order Total
                                </div>

                                <div class="od-total-description">
                                    Total value of all selected services
                                </div>

                            </div>

                            <div class="od-total-value">
                                KSh {{ number_format($totalAmount, 2) }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================
                 CUSTOMER NOTES
            ===================================================== --}}
            @if($order->notes)

                <div class="od-card mb-4">

                    <div class="od-card-header">

                        <div class="d-flex align-items-center gap-3">

                            <div class="od-section-icon od-icon-warning">
                                <i class="bi bi-chat-left-text-fill"></i>
                            </div>

                            <div>

                                <h6 class="od-card-title">
                                    Customer Notes
                                </h6>

                                <p class="od-card-subtitle">
                                    Additional instructions from the customer
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="od-card-body">

                        <div class="od-notes">
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


            {{-- ====================================================
                 ORDER SUMMARY
            ===================================================== --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="od-section-icon od-icon-navy">
                            <i class="bi bi-receipt-cutoff"></i>
                        </div>

                        <div>

                            <h6 class="od-card-title">
                                Order Summary
                            </h6>

                            <p class="od-card-subtitle">
                                Key order information
                            </p>

                        </div>

                    </div>

                </div>

                <div class="od-card-body">

                    <div class="od-info-item">

                        <div class="od-info-label">
                            Order Number
                        </div>

                        <div class="od-info-value">
                            #{{ $order->order_number }}
                        </div>

                    </div>


                    <div class="od-info-item">

                        <div class="od-info-label">
                            Services
                        </div>

                        <div class="od-info-value muted">
                            {{ $order->service_name ?: 'Multiple Services' }}
                        </div>

                    </div>


                    <div class="od-info-item">

                        <div class="od-info-label">
                            Total Quantity
                        </div>

                        <div class="od-info-value">
                            {{ $quantityDisplay }}
                        </div>

                    </div>


                    <div class="od-info-item">

                        <div class="od-info-label">
                            Payment Status
                        </div>

                        <div class="od-info-value">

                            @if(in_array($paymentStatus, ['paid', 'completed']))

                                <span class="od-pill od-pill-paid">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Paid
                                </span>

                            @elseif($paymentStatus === 'failed')

                                <span class="od-pill od-pill-failed">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Failed
                                </span>

                            @else

                                <span class="od-pill od-pill-pending">
                                    <i class="bi bi-clock-fill"></i>
                                    Pending
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="mt-4">

                        <div class="od-payment-card">

                            <div class="od-payment-status">

                                <div>

                                    <div class="od-payment-label">
                                        Payment Overview
                                    </div>

                                    <div class="fw-bold mt-1">
                                        {{ in_array($paymentStatus, ['paid', 'completed']) ? 'Payment received' : 'Payment pending' }}
                                    </div>

                                </div>

                                <div class="od-section-icon od-icon-blue">
                                    <i class="bi bi-credit-card-2-front"></i>
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="mt-3">

                        <div class="od-total-box">

                            <div class="od-total-label">
                                Total Amount
                            </div>

                            <div class="od-total-value">
                                KSh {{ number_format($totalAmount, 2) }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================
                 PICKUP & DELIVERY
            ===================================================== --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="od-section-icon od-icon-blue">
                            <i class="bi bi-calendar2-check-fill"></i>
                        </div>

                        <div>

                            <h6 class="od-card-title">
                                Pickup & Delivery
                            </h6>

                            <p class="od-card-subtitle">
                                Customer's requested schedule
                            </p>

                        </div>

                    </div>

                </div>

                <div class="od-card-body">

                    <div class="od-info-item">

                        <div class="od-info-label">
                            Pickup Date
                        </div>

                        <div class="od-info-value">

                            @if($order->pickup_date)

                                <i class="bi bi-calendar3 text-primary me-1"></i>

                                {{ \Carbon\Carbon::parse($order->pickup_date)->format('D, d M Y') }}

                            @else

                                <span class="text-muted fw-normal">
                                    Not specified
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="od-info-item">

                        <div class="od-info-label">
                            Pickup Time
                        </div>

                        <div class="od-info-value">

                            @if($order->pickup_time)

                                <i class="bi bi-clock text-primary me-1"></i>

                                {{ \Carbon\Carbon::parse($order->pickup_time)->format('g:i A') }}

                            @else

                                <span class="text-muted fw-normal">
                                    Not specified
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="od-info-item no-border">

                        <div class="od-info-label">
                            Delivery Address
                        </div>

                        <div class="od-info-value muted">

                            <i class="bi bi-geo-alt-fill text-primary me-1"></i>

                            {{ $order->delivery_address ?: 'Not provided' }}

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================
                 TIMELINE
            ===================================================== --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="od-section-icon od-icon-purple">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <div>

                            <h6 class="od-card-title">
                                Order Timeline
                            </h6>

                            <p class="od-card-subtitle">
                                Order activity and progression
                            </p>

                        </div>

                    </div>

                </div>

                <div class="od-card-body">

                    <div class="od-timeline">

                        <div class="od-timeline-item">

                            <div class="od-timeline-dot"></div>

                            <div>

                                <div class="od-timeline-title">
                                    Order Created
                                </div>

                                <div class="od-timeline-date">
                                    {{ $order->created_at?->format('d M Y, h:i A') ?? 'Not available' }}
                                </div>

                            </div>

                        </div>


                        <div class="od-timeline-item">

                            <div class="od-timeline-dot {{ $status === 'pending' ? 'muted' : '' }}"></div>

                            <div>

                                <div class="od-timeline-title">
                                    Current Status
                                </div>

                                <div class="od-timeline-date">
                                    {{ $statusLabel }}
                                </div>

                            </div>

                        </div>


                        <div class="od-timeline-item">

                            <div class="od-timeline-dot muted"></div>

                            <div>

                                <div class="od-timeline-title">
                                    Last Updated
                                </div>

                                <div class="od-timeline-date">
                                    {{ $order->updated_at?->format('d M Y, h:i A') ?? 'Not available' }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ====================================================
                 QUICK ACTIONS
            ===================================================== --}}
            <div class="od-card mb-4">

                <div class="od-card-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="od-section-icon od-icon-blue">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>

                        <div>

                            <h6 class="od-card-title">
                                Quick Actions
                            </h6>

                            <p class="od-card-subtitle">
                                Customer communication shortcuts
                            </p>

                        </div>

                    </div>

                </div>

                <div class="od-card-body d-grid gap-2">

                    @if($order->phone)

                        <a href="tel:{{ $order->phone }}"
                           class="od-quick-action">

                            <span class="od-quick-action-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </span>

                            <span>
                                Call Customer
                            </span>

                            <i class="bi bi-chevron-right ms-auto text-muted"></i>

                        </a>


                        @if($whatsappNumber)

                            <a href="https://wa.me/{{ $whatsappNumber }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="od-quick-action">

                                <span class="od-quick-action-icon">
                                    <i class="bi bi-whatsapp"></i>
                                </span>

                                <span>
                                    WhatsApp Customer
                                </span>

                                <i class="bi bi-box-arrow-up-right ms-auto text-muted"></i>

                            </a>

                        @endif

                    @endif


                    @if($order->email)

                        <a href="mailto:{{ $order->email }}"
                           class="od-quick-action">

                            <span class="od-quick-action-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </span>

                            <span>
                                Email Customer
                            </span>

                            <i class="bi bi-chevron-right ms-auto text-muted"></i>

                        </a>

                    @endif


                    <a href="{{ route('online-orders.index') }}"
                       class="od-quick-action">

                        <span class="od-quick-action-icon">
                            <i class="bi bi-list-ul"></i>
                        </span>

                        <span>
                            View All Online Orders
                        </span>

                        <i class="bi bi-chevron-right ms-auto text-muted"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection