@extends('components.layout')

@section('title', 'Online Orders')

@push('styles')
<style>
    :root {
        --oo-navy: #071a33;
        --oo-navy-2: #0b2a4a;
        --oo-blue: #0d6efd;
        --oo-blue-dark: #0b5ed7;
        --oo-blue-light: #eaf3ff;
        --oo-blue-soft: #f4f8ff;

        --oo-white: #ffffff;
        --oo-bg: #f5f8fc;
        --oo-surface: #ffffff;
        --oo-text: #142033;
        --oo-muted: #718096;
        --oo-border: #e3eaf2;

        --oo-warning: #f59e0b;
        --oo-danger: #dc3545;
        --oo-success: #198754;
        --oo-purple: #6f42c1;
        --oo-cyan: #0ea5e9;

        --oo-shadow-sm: 0 4px 16px rgba(7, 26, 51, .05);
        --oo-shadow-md: 0 14px 34px rgba(7, 26, 51, .08);
        --oo-shadow-lg: 0 20px 50px rgba(7, 26, 51, .12);
    }

    /* =========================================================
       PAGE
    ========================================================== */

    .online-orders-page {
        width: 100%;
        color: var(--oo-text);
    }

    /* =========================================================
       HERO
    ========================================================== */

    .oo-hero {
        position: relative;
        overflow: hidden;
        padding: 30px 32px;
        border-radius: 22px;
        color: #fff;

        background:
            radial-gradient(
                circle at 90% 5%,
                rgba(255,255,255,.17),
                transparent 28%
            ),
            radial-gradient(
                circle at 72% 110%,
                rgba(255,255,255,.08),
                transparent 28%
            ),
            linear-gradient(
                135deg,
                #071a33 0%,
                #0b2a4a 42%,
                #0d6efd 100%
            );

        box-shadow:
            0 20px 45px rgba(13,110,253,.18);
    }

    .oo-hero::before {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        right: -110px;
        top: -170px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.12);
    }

    .oo-hero::after {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        right: 100px;
        bottom: -170px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
    }

    .oo-hero-content {
        position: relative;
        z-index: 2;
    }

    .oo-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 6px 10px;
        margin-bottom: 10px;

        border-radius: 999px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.18);

        font-size: .66rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .oo-hero h1 {
        margin: 0;
        font-size: 1.55rem;
        font-weight: 850;
        letter-spacing: -.035em;
    }

    .oo-hero p {
        margin: 7px 0 0;
        color: rgba(255,255,255,.78);
        font-size: .84rem;
        max-width: 650px;
    }

    .oo-hero-meta {
        position: relative;
        z-index: 2;

        display: flex;
        align-items: center;
        gap: 10px;

        padding: 11px 15px;

        border-radius: 13px;
        background: rgba(255,255,255,.10);
        border: 1px solid rgba(255,255,255,.18);

        backdrop-filter: blur(12px);
        white-space: nowrap;
    }

    .oo-hero-meta-icon {
        width: 35px;
        height: 35px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;
        background: rgba(255,255,255,.13);
    }

    .oo-hero-meta strong {
        display: block;
        font-size: 1rem;
        line-height: 1;
    }

    .oo-hero-meta span {
        display: block;
        margin-top: 4px;

        color: rgba(255,255,255,.65);
        font-size: .63rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    /* =========================================================
       ALERTS
    ========================================================== */

    .oo-alert {
        border-radius: 13px;
        border: 1px solid transparent;
        box-shadow: var(--oo-shadow-sm);
        font-size: .8rem;
    }

    .oo-alert-success {
        background: #effaf5;
        border-color: #ccebd9;
        color: #146c43;
    }

    .oo-alert-danger {
        background: #fff5f5;
        border-color: #f4caca;
        color: #b02a37;
    }

    /* =========================================================
       KPI CARDS
    ========================================================== */

    .oo-kpi {
        position: relative;
        overflow: hidden;

        height: 100%;

        padding: 18px;

        background: var(--oo-surface);
        border: 1px solid var(--oo-border);
        border-radius: 17px;

        box-shadow: var(--oo-shadow-sm);

        transition:
            transform .2s ease,
            box-shadow .2s ease,
            border-color .2s ease;
    }

    .oo-kpi:hover {
        transform: translateY(-3px);
        border-color: #cbd9ea;
        box-shadow: var(--oo-shadow-md);
    }

    .oo-kpi::before {
        content: "";

        position: absolute;
        top: 0;
        left: 0;
        right: 0;

        height: 3px;

        background: var(--oo-blue);
    }

    .oo-kpi.warning::before {
        background: var(--oo-warning);
    }

    .oo-kpi.processing::before {
        background: var(--oo-cyan);
    }

    .oo-kpi.success::before {
        background: var(--oo-success);
    }

    .oo-kpi-icon {
        width: 45px;
        height: 45px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 12px;

        background: var(--oo-blue-light);
        color: var(--oo-blue);

        font-size: 1.1rem;
    }

    .oo-kpi.warning .oo-kpi-icon {
        background: #fff8e7;
        color: #b77900;
    }

    .oo-kpi.processing .oo-kpi-icon {
        background: #edf8ff;
        color: #0284c7;
    }

    .oo-kpi.success .oo-kpi-icon {
        background: #ecf9f2;
        color: #16834d;
    }

    .oo-kpi-label {
        margin-bottom: 6px;

        color: var(--oo-muted);

        font-size: .66rem;
        font-weight: 800;

        text-transform: uppercase;
        letter-spacing: .065em;
    }

    .oo-kpi-value {
        color: var(--oo-navy);

        font-size: 1.75rem;
        line-height: 1;

        font-weight: 900;
        letter-spacing: -.04em;
    }

    .oo-kpi-description {
        margin-top: 7px;

        color: #94a3b8;
        font-size: .68rem;
    }

    /* =========================================================
       ADVANCED CONTROL PANEL
    ========================================================== */

    .oo-controls {
        padding: 18px;

        background: var(--oo-white);
        border: 1px solid var(--oo-border);
        border-radius: 17px;

        box-shadow: var(--oo-shadow-sm);
    }

    .oo-control-title {
        display: flex;
        align-items: center;
        gap: 8px;

        margin-bottom: 15px;

        color: var(--oo-navy);
        font-size: .8rem;
        font-weight: 850;
    }

    .oo-control-title-icon {
        width: 30px;
        height: 30px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 8px;

        background: var(--oo-blue-light);
        color: var(--oo-blue);
    }

    .oo-controls label {
        margin-bottom: 6px;

        color: #526176;

        font-size: .68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .045em;
    }

    .oo-controls .form-control,
    .oo-controls .form-select {
        min-height: 43px;

        border: 1px solid #dbe4ee;
        border-radius: 10px;

        background: #fbfdff;

        color: var(--oo-text);

        font-size: .78rem;
        box-shadow: none;

        transition: .2s ease;
    }

    .oo-controls .form-control:focus,
    .oo-controls .form-select:focus {
        border-color: var(--oo-blue);
        background: #fff;

        box-shadow:
            0 0 0 3px rgba(13,110,253,.09);
    }

    .oo-search {
        position: relative;
    }

    .oo-search i {
        position: absolute;

        left: 13px;
        top: 50%;

        transform: translateY(-50%);

        color: #94a3b8;

        pointer-events: none;
    }

    .oo-search input {
        padding-left: 38px;
    }

    .oo-refresh {
        min-height: 43px;

        border: 1px solid #cfe0f5;
        border-radius: 10px;

        background: #f7fbff;
        color: var(--oo-blue-dark);

        font-size: .76rem;
        font-weight: 800;

        transition: .2s ease;
    }

    .oo-refresh:hover {
        background: var(--oo-blue);
        border-color: var(--oo-blue);
        color: #fff;
    }

    .oo-clear {
        color: var(--oo-blue);
        font-size: .72rem;
        font-weight: 750;

        text-decoration: none;
    }

    .oo-clear:hover {
        color: var(--oo-blue-dark);
        text-decoration: underline;
    }

    .oo-results {
        color: var(--oo-muted);
        font-size: .72rem;
        font-weight: 650;
    }

    /* =========================================================
       QUICK STATUS FILTERS
    ========================================================== */

    .oo-quick-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .oo-quick-filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 7px 11px;

        border: 1px solid #dfe7f0;
        border-radius: 999px;

        background: #fff;

        color: #5f6f83;

        font-size: .68rem;
        font-weight: 800;

        cursor: pointer;

        transition: .18s ease;
    }

    .oo-quick-filter:hover {
        border-color: #b9d1ee;
        background: #f6faff;
        color: var(--oo-blue);
    }

    .oo-quick-filter.active {
        background: var(--oo-blue);
        border-color: var(--oo-blue);
        color: #fff;
        box-shadow: 0 5px 14px rgba(13,110,253,.18);
    }

    /* =========================================================
       TABLE CARD
    ========================================================== */

    .oo-table-card {
        overflow: hidden;

        background: #fff;
        border: 1px solid var(--oo-border);
        border-radius: 17px;

        box-shadow: var(--oo-shadow-sm);
    }

    .oo-table-header {
        min-height: 70px;

        padding: 14px 17px;

        border-bottom: 1px solid var(--oo-border);
        background: #fff;
    }

    .oo-table-icon {
        width: 36px;
        height: 36px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: var(--oo-blue-light);
        color: var(--oo-blue);
    }

    .oo-table-title {
        color: var(--oo-navy);
        font-size: .82rem;
        font-weight: 850;
    }

    .oo-table-subtitle {
        color: var(--oo-muted);
        font-size: .67rem;
    }

    .oo-table-total {
        padding: 6px 10px;

        border-radius: 999px;

        background: #f5f8fc;
        border: 1px solid #e3eaf2;

        color: #64748b;

        font-size: .65rem;
        font-weight: 800;
    }

    .oo-table-wrapper {
        overflow-x: auto;
    }

    .oo-table {
        min-width: 1350px;
        margin: 0;
    }

    .oo-table thead th {
        padding: 12px 11px;

        background: #f8fafd;

        border-bottom: 1px solid var(--oo-border);

        color: #718096;

        font-size: .63rem;
        font-weight: 850;

        text-transform: uppercase;
        letter-spacing: .055em;

        white-space: nowrap;
    }

    .oo-table tbody td {
        padding: 13px 11px;

        border-bottom: 1px solid #edf1f5;

        vertical-align: middle;
    }

    .oo-table tbody tr {
        transition: background .16s ease;
    }

    .oo-table tbody tr:hover {
        background: #f8fbff;
    }

    .oo-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* =========================================================
       ORDER ID
    ========================================================== */

    .oo-order-id {
        color: var(--oo-blue-dark);

        font-size: .77rem;
        font-weight: 900;
        letter-spacing: -.015em;
    }

    .oo-order-type {
        display: inline-flex;
        align-items: center;
        gap: 4px;

        margin-top: 4px;

        color: #94a3b8;

        font-size: .61rem;
        font-weight: 700;
    }

    /* =========================================================
       CUSTOMER
    ========================================================== */

    .oo-avatar {
        width: 38px;
        height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        border-radius: 11px;

        background:
            linear-gradient(
                135deg,
                var(--oo-blue),
                var(--oo-blue-dark)
            );

        color: #fff;

        font-size: .72rem;
        font-weight: 850;

        box-shadow:
            0 5px 12px rgba(13,110,253,.16);
    }

    .oo-customer-name {
        max-width: 150px;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;

        color: var(--oo-navy);

        font-size: .76rem;
        font-weight: 800;
    }

    .oo-customer-label {
        margin-top: 3px;

        color: #94a3b8;

        font-size: .61rem;
    }

    /* =========================================================
       CONTACT
    ========================================================== */

    .oo-contact {
        font-size: .72rem;
        white-space: nowrap;
    }

    .oo-contact + .oo-contact {
        margin-top: 5px;
    }

    .oo-contact i {
        width: 15px;
        color: #94a3b8;
    }

    /* =========================================================
       SERVICE
    ========================================================== */

    .oo-service-name {
        max-width: 190px;

        overflow: hidden;
        text-overflow: ellipsis;

        color: var(--oo-navy);

        font-size: .75rem;
        font-weight: 800;
    }

    .oo-service-meta {
        margin-top: 4px;

        color: var(--oo-muted);

        font-size: .62rem;
    }

    /* =========================================================
       PICKUP
    ========================================================== */

    .oo-date-main {
        color: var(--oo-text);
        font-size: .72rem;
        font-weight: 750;
    }

    .oo-date-sub {
        margin-top: 4px;

        color: var(--oo-muted);
        font-size: .63rem;
    }

    .oo-address {
        max-width: 190px;

        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;

        margin-top: 4px;

        color: #94a3b8;
        font-size: .61rem;
    }

    /* =========================================================
       AMOUNT
    ========================================================== */

    .oo-amount {
        color: var(--oo-navy);

        font-size: .8rem;
        font-weight: 900;

        white-space: nowrap;
    }

    .oo-amount-label {
        margin-top: 4px;

        color: #94a3b8;
        font-size: .6rem;
    }

    /* =========================================================
       PAYMENT STATUS
    ========================================================== */

    .oo-payment-control {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .oo-payment-select {
        min-width: 112px;
        height: 34px;

        padding: 0 25px 0 11px;

        border-radius: 999px;

        font-size: .67rem;
        font-weight: 850;

        cursor: pointer;

        outline: none;

        transition:
            transform .15s ease,
            box-shadow .18s ease;
    }

    .oo-payment-select:hover {
        transform: translateY(-1px);
    }

    .oo-payment-select:focus {
        box-shadow:
            0 0 0 3px rgba(13,110,253,.10);
    }

    .oo-payment-select.status-paid {
        background: #edf9f3;
        color: #167747;
        border: 1px solid #bfe7cf;
    }

    .oo-payment-select.status-not-paid {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    .oo-payment-select.status-saving {
        opacity: .6;
        cursor: wait;
    }

    .oo-payment-message {
        display: none;

        align-items: center;
        gap: 4px;

        font-size: .6rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .oo-payment-message.show {
        display: inline-flex;
    }

    .oo-payment-saving {
        color: #64748b;
    }

    .oo-payment-saved {
        color: var(--oo-success);
    }

    .oo-payment-error {
        color: var(--oo-danger);
    }

    /* =========================================================
       ORDER STATUS
    ========================================================== */

    .oo-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;

        padding: 6px 9px;

        border: 1px solid transparent;
        border-radius: 999px;

        font-size: .64rem;
        font-weight: 850;

        white-space: nowrap;
    }

    .oo-status.pending {
        background: #fff9e9;
        color: #a16207;
        border-color: #fde68a;
    }

    .oo-status.processing {
        background: #eef7ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .oo-status.ready {
        background: #f1f0ff;
        color: #5146a5;
        border-color: #c7d2fe;
    }

    .oo-status.completed,
    .oo-status.delivered {
        background: #edf9f3;
        color: #15803d;
        border-color: #bbf7d0;
    }

    .oo-status.cancelled {
        background: #fff2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    /* =========================================================
       ACTION
    ========================================================== */

    .oo-action {
        width: 35px;
        height: 35px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #dce5ef;
        border-radius: 9px;

        background: #fff;
        color: var(--oo-blue);

        transition: .18s ease;
    }

    .oo-action:hover {
        background: var(--oo-blue);
        border-color: var(--oo-blue);
        color: #fff;

        transform: translateY(-1px);

        box-shadow:
            0 6px 15px rgba(13,110,253,.20);
    }

    /* =========================================================
       EMPTY STATE
    ========================================================== */

    .oo-empty {
        padding: 65px 20px;
        text-align: center;
    }

    .oo-empty-icon {
        width: 72px;
        height: 72px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 15px;

        border-radius: 20px;

        background: #f5f8fc;
        color: #b9c6d6;

        font-size: 1.8rem;
    }

    .oo-empty h5 {
        color: var(--oo-navy);
        font-size: .9rem;
        font-weight: 850;
    }

    .oo-empty p {
        max-width: 450px;

        margin: 6px auto 0;

        color: var(--oo-muted);
        font-size: .73rem;
    }

    .oo-filter-empty {
        display: none;
    }

    .oo-filter-empty.show {
        display: table-row;
    }

    /* =========================================================
       PAGINATION
    ========================================================== */

    .oo-pagination {
        padding: 15px 17px;

        border-top: 1px solid var(--oo-border);
        background: #fff;
    }

    .oo-pagination .pagination {
        margin: 0;
    }

    .oo-pagination .page-link {
        border-color: #dfe7f0;
        color: var(--oo-blue);
        font-size: .72rem;
    }

    .oo-pagination .page-item.active .page-link {
        background: var(--oo-blue);
        border-color: var(--oo-blue);
        color: #fff;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 991.98px) {
        .oo-hero {
            padding: 24px;
        }

        .oo-hero-meta {
            width: 100%;
        }
    }

    @media (max-width: 767.98px) {
        .oo-hero {
            border-radius: 17px;
            padding: 21px;
        }

        .oo-hero h1 {
            font-size: 1.25rem;
        }

        .oo-hero p {
            font-size: .76rem;
        }

        .oo-controls {
            padding: 14px;
        }

        .oo-table-card {
            border-radius: 14px;
        }

        .oo-table-header {
            padding: 13px;
        }

        .oo-kpi-value {
            font-size: 1.55rem;
        }
    }
</style>
@endpush


@section('content')

<div class="container-fluid px-0 online-orders-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <div class="oo-hero mb-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-4">

            <div class="oo-hero-content">

                <div class="oo-eyebrow">
                    <i class="bi bi-broadcast"></i>
                    Live Order Management
                </div>

                <h1>
                    Online Orders
                </h1>

                <p>
                    Monitor customer orders, manage payment status,
                    track fulfilment progress and access complete order details.
                </p>

            </div>

            <div class="oo-hero-meta">

                <div class="oo-hero-meta-icon">
                    <i class="bi bi-bag-check-fill"></i>
                </div>

                <div>
                    <strong>
                        {{ $counts['total'] ?? 0 }}
                    </strong>

                    <span>
                        Total Orders
                    </span>
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         FLASH MESSAGES
    ========================================================== --}}

    @if(session('success'))

        <div class="alert oo-alert oo-alert-success alert-dismissible fade show mb-4">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert oo-alert oo-alert-danger alert-dismissible fade show mb-4">

            <i class="bi bi-exclamation-triangle-fill me-2"></i>

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- =========================================================
         VALIDATION ERRORS
    ========================================================== --}}

    @if($errors->any())

        <div class="alert oo-alert oo-alert-danger alert-dismissible fade show mb-4">

            <div class="fw-bold mb-2">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                Please review the following:
            </div>

            <ul class="mb-0 ps-4">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- =========================================================
         KPI CARDS
    ========================================================== --}}

    <div class="row g-3 mb-4">

        {{-- TOTAL --}}
        <div class="col-6 col-xl-3">

            <div class="oo-kpi">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div class="oo-kpi-label">
                            Total Orders
                        </div>

                        <div class="oo-kpi-value">
                            {{ $counts['total'] ?? 0 }}
                        </div>

                        <div class="oo-kpi-description">
                            All online orders
                        </div>

                    </div>

                    <div class="oo-kpi-icon">
                        <i class="bi bi-bag-check"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- PENDING --}}
        <div class="col-6 col-xl-3">

            <div class="oo-kpi warning">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div class="oo-kpi-label">
                            Pending
                        </div>

                        <div class="oo-kpi-value">
                            {{ $counts['pending'] ?? 0 }}
                        </div>

                        <div class="oo-kpi-description">
                            Awaiting processing
                        </div>

                    </div>

                    <div class="oo-kpi-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- PROCESSING --}}
        <div class="col-6 col-xl-3">

            <div class="oo-kpi processing">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div class="oo-kpi-label">
                            Processing
                        </div>

                        <div class="oo-kpi-value">
                            {{ $counts['processing'] ?? 0 }}
                        </div>

                        <div class="oo-kpi-description">
                            Currently being handled
                        </div>

                    </div>

                    <div class="oo-kpi-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- COMPLETED --}}
        <div class="col-6 col-xl-3">

            <div class="oo-kpi success">

                <div class="d-flex justify-content-between align-items-start">

                    <div>

                        <div class="oo-kpi-label">
                            Completed
                        </div>

                        <div class="oo-kpi-value">
                            {{ $counts['completed'] ?? 0 }}
                        </div>

                        <div class="oo-kpi-description">
                            Successfully completed
                        </div>

                    </div>

                    <div class="oo-kpi-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         FILTER / SEARCH PANEL
    ========================================================== --}}

    <div class="oo-controls mb-4">

        <div class="oo-control-title">

            <span class="oo-control-title-icon">
                <i class="bi bi-sliders"></i>
            </span>

            Order Search & Filters

        </div>


        <div class="row g-3 align-items-end">

            {{-- SEARCH --}}
            <div class="col-xl-5 col-lg-5">

                <label for="orderSearch">
                    Search Orders
                </label>

                <div class="oo-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="orderSearch"
                        class="form-control"
                        placeholder="Order number, customer, phone, email or service..."
                        autocomplete="off"
                    >

                </div>

            </div>


            {{-- ORDER STATUS --}}
            <div class="col-xl-2 col-lg-2 col-md-4">

                <label for="statusFilter">
                    Order Status
                </label>

                <select
                    id="statusFilter"
                    class="form-select"
                >

                    <option value="">
                        All Statuses
                    </option>

                    <option value="pending">
                        Pending
                    </option>

                    <option value="processing">
                        Processing
                    </option>

                    <option value="ready">
                        Ready
                    </option>

                    <option value="completed">
                        Completed
                    </option>

                    <option value="delivered">
                        Delivered
                    </option>

                    <option value="cancelled">
                        Cancelled
                    </option>

                </select>

            </div>


            {{-- PAYMENT --}}
            <div class="col-xl-2 col-lg-2 col-md-4">

                <label for="paymentFilter">
                    Payment Status
                </label>

                <select
                    id="paymentFilter"
                    class="form-select"
                >

                    <option value="">
                        All Payments
                    </option>

                    <option value="paid">
                        Paid
                    </option>

                    <option value="not_paid">
                        Not Paid
                    </option>

                </select>

            </div>


            {{-- REFRESH --}}
            <div class="col-xl-3 col-lg-3 col-md-4">

                <button
                    type="button"
                    id="refreshOrdersBtn"
                    class="btn oo-refresh w-100"
                >

                    <i class="bi bi-arrow-clockwise me-1"></i>

                    Refresh Orders

                </button>

            </div>

        </div>


        {{-- QUICK FILTERS --}}
        <div class="mt-3">

            <div class="small fw-bold text-muted mb-2">
                Quick Filters
            </div>

            <div class="oo-quick-filters">

                <button
                    type="button"
                    class="oo-quick-filter active"
                    data-quick-filter=""
                >
                    <i class="bi bi-grid"></i>
                    All
                </button>

                <button
                    type="button"
                    class="oo-quick-filter"
                    data-quick-filter="pending"
                >
                    <i class="bi bi-clock"></i>
                    Pending
                </button>

                <button
                    type="button"
                    class="oo-quick-filter"
                    data-quick-filter="processing"
                >
                    <i class="bi bi-arrow-repeat"></i>
                    Processing
                </button>

                <button
                    type="button"
                    class="oo-quick-filter"
                    data-quick-filter="ready"
                >
                    <i class="bi bi-check2"></i>
                    Ready
                </button>

                <button
                    type="button"
                    class="oo-quick-filter"
                    data-quick-filter="completed"
                >
                    <i class="bi bi-check-circle"></i>
                    Completed
                </button>

                <button
                    type="button"
                    class="oo-quick-filter"
                    data-quick-filter="not_paid"
                >
                    <i class="bi bi-credit-card"></i>
                    Unpaid
                </button>

            </div>

        </div>


        <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 gap-2">

            <span
                class="oo-results"
                id="filterResultCount"
            >
                Showing {{ $orders->count() }}
                {{ Str::plural('order', $orders->count()) }}
            </span>

            <a
                href="#"
                class="oo-clear"
                id="clearFiltersBtn"
            >
                <i class="bi bi-x-circle me-1"></i>
                Clear all filters
            </a>

        </div>

    </div>


    {{-- =========================================================
         ORDERS TABLE
    ========================================================== --}}

    <div class="oo-table-card">

        <div class="oo-table-header d-flex justify-content-between align-items-center gap-3">

            <div class="d-flex align-items-center gap-2">

                <span class="oo-table-icon">
                    <i class="bi bi-list-check"></i>
                </span>

                <div>

                    <div class="oo-table-title">
                        Online Orders
                    </div>

                    <div class="oo-table-subtitle">
                        Latest customer orders and fulfilment activity
                    </div>

                </div>

            </div>

            <span class="oo-table-total">

                {{ $orders->total() ?? $orders->count() }}

                {{ Str::plural('order', $orders->total() ?? $orders->count()) }}

            </span>

        </div>


        <div class="oo-table-wrapper">

            <table
                class="table oo-table align-middle"
                id="ordersTable"
            >

                <thead>

                    <tr>

                        <th class="ps-4">
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Contact
                        </th>

                        <th>
                            Service
                        </th>

                        <th>
                            Pickup / Delivery
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Payment
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Created
                        </th>

                        <th class="text-center pe-4">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody id="ordersTableBody">

                    @forelse($orders as $order)

                        @php

                            $initials = collect(
                                preg_split(
                                    '/\s+/',
                                    trim($order->customer_name ?? '')
                                )
                            )
                            ->filter()
                            ->map(
                                fn($name) =>
                                    strtoupper(substr($name, 0, 1))
                            )
                            ->take(2)
                            ->implode('');

                            /*
                             * PAYMENT
                             */
                            $paymentStatus = strtolower(
                                trim($order->payment_status ?? '')
                            );

                            $isPaid =
                                $paymentStatus === 'paid';

                            $normalizedPaymentStatus =
                                $isPaid
                                    ? 'paid'
                                    : 'not_paid';

                            /*
                             * ORDER STATUS
                             */
                            $status = strtolower(
                                trim(
                                    $order->status ?? 'pending'
                                )
                            );

                            $statusIcons = [

                                'pending' =>
                                    'bi-clock',

                                'processing' =>
                                    'bi-arrow-repeat',

                                'ready' =>
                                    'bi-check2',

                                'completed' =>
                                    'bi-check-circle',

                                'delivered' =>
                                    'bi-truck',

                                'cancelled' =>
                                    'bi-x-circle',

                            ];

                            $statusIcon =
                                $statusIcons[$status]
                                ?? 'bi-info-circle';

                            /*
                             * PAYMENT UPDATE ROUTE
                             */
                            $paymentUpdateUrl = route(
                                'online-orders.payment-status.update',
                                $order->id
                            );

                        @endphp


                        <tr
                            class="order-row"
                            data-search="{{ strtolower(
                                ($order->order_number ?? '') . ' ' .
                                ($order->customer_name ?? '') . ' ' .
                                ($order->phone ?? '') . ' ' .
                                ($order->email ?? '') . ' ' .
                                ($order->service_name ?? '') . ' ' .
                                ($order->delivery_address ?? '')
                            ) }}"
                            data-status="{{ $status }}"
                            data-payment="{{ $normalizedPaymentStatus }}"
                        >

                            {{-- ORDER --}}
                            <td class="ps-4">

                                <div class="oo-order-id">
                                    #{{ $order->order_number }}
                                </div>

                                <div class="oo-order-type">

                                    <i class="bi bi-globe2"></i>

                                    Online Order

                                </div>

                            </td>


                            {{-- CUSTOMER --}}
                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    <div class="oo-avatar">
                                        {{ $initials ?: '—' }}
                                    </div>

                                    <div>

                                        <div class="oo-customer-name">
                                            {{ $order->customer_name }}
                                        </div>

                                        <div class="oo-customer-label">
                                            Customer
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- CONTACT --}}
                            <td>

                                <div class="oo-contact">

                                    <i class="bi bi-telephone-fill"></i>

                                    {{ $order->phone }}

                                </div>

                                @if($order->email)

                                    <div class="oo-contact text-muted">

                                        <i class="bi bi-envelope-fill"></i>

                                        {{ $order->email }}

                                    </div>

                                @endif

                            </td>


                            {{-- SERVICE --}}
                            <td>

                                <div
                                    class="oo-service-name"
                                    title="{{ $order->service_name }}"
                                >
                                    {{ $order->service_name }}
                                </div>

                                <div class="oo-service-meta">

                                    <i class="bi bi-box-seam me-1"></i>

                                    Qty:
                                    {{ rtrim(
                                        rtrim(
                                            (string) $order->quantity,
                                            '0'
                                        ),
                                        '.'
                                    ) }}

                                </div>

                            </td>


                            {{-- PICKUP --}}
                            <td>

                                <div class="oo-date-main">

                                    <i class="bi bi-calendar-event me-1"></i>

                                    {{ optional($order->pickup_date)->format('d M Y') }}

                                </div>

                                @if($order->pickup_time)

                                    <div class="oo-date-sub">

                                        <i class="bi bi-clock me-1"></i>

                                        {{ \Carbon\Carbon::parse($order->pickup_time)->format('g:i A') }}

                                    </div>

                                @endif

                                @if($order->delivery_address)

                                    <div
                                        class="oo-address"
                                        title="{{ $order->delivery_address }}"
                                    >

                                        <i class="bi bi-geo-alt me-1"></i>

                                        {{ \Illuminate\Support\Str::limit(
                                            $order->delivery_address,
                                            28
                                        ) }}

                                    </div>

                                @endif

                            </td>


                            {{-- AMOUNT --}}
                            <td>

                                <div class="oo-amount">

                                    KSh
                                    {{ number_format(
                                        $order->total_amount,
                                        2
                                    ) }}

                                </div>

                                <div class="oo-amount-label">
                                    Order Total
                                </div>

                            </td>


                            {{-- PAYMENT --}}
                            <td>

                                <div class="oo-payment-control">

                                    <select
                                        class="oo-payment-select {{ $isPaid ? 'status-paid' : 'status-not-paid' }}"
                                        data-payment-url="{{ $paymentUpdateUrl }}"
                                        data-original-status="{{ $normalizedPaymentStatus }}"
                                        data-order-number="{{ $order->order_number }}"
                                        aria-label="Payment status for order {{ $order->order_number }}"
                                    >

                                        <option
                                            value="not_paid"
                                            {{ !$isPaid ? 'selected' : '' }}
                                        >
                                            Not Paid
                                        </option>

                                        <option
                                            value="paid"
                                            {{ $isPaid ? 'selected' : '' }}
                                        >
                                            Paid
                                        </option>

                                    </select>


                                    <span class="oo-payment-message oo-payment-saving">

                                        <span
                                            class="spinner-border spinner-border-sm"
                                            style="width:.65rem;height:.65rem;"
                                        ></span>

                                        Saving

                                    </span>


                                    <span class="oo-payment-message oo-payment-saved">

                                        <i class="bi bi-check-circle-fill"></i>

                                        Saved

                                    </span>


                                    <span class="oo-payment-message oo-payment-error">

                                        <i class="bi bi-exclamation-circle-fill"></i>

                                        Failed

                                    </span>

                                </div>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                <span class="oo-status {{ $status }}">

                                    <i class="bi {{ $statusIcon }}"></i>

                                    {{ ucfirst($status) }}

                                </span>

                            </td>


                            {{-- CREATED --}}
                            <td>

                                <div class="oo-date-main">

                                    {{ optional($order->created_at)->format('d M Y') }}

                                </div>

                                <div class="oo-date-sub">

                                    {{ optional($order->created_at)->format('h:i A') }}

                                </div>

                            </td>


                            {{-- ACTION --}}
                            <td class="text-center pe-4">

                                <a
                                    href="{{ route(
                                        'online-orders.show',
                                        $order->id
                                    ) }}"
                                    class="oo-action"
                                    title="View Order Details"
                                    aria-label="View order {{ $order->order_number }}"
                                >

                                    <i class="bi bi-eye"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr id="noOrdersRow">

                            <td colspan="10">

                                <div class="oo-empty">

                                    <div class="oo-empty-icon">

                                        <i class="bi bi-bag-x"></i>

                                    </div>

                                    <h5>
                                        No Online Orders Yet
                                    </h5>

                                    <p>
                                        Customer orders placed through your
                                        online ordering system will appear here.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse


                    {{-- FILTER EMPTY --}}

                    <tr
                        id="filterEmptyRow"
                        class="oo-filter-empty"
                    >

                        <td colspan="10">

                            <div class="oo-empty">

                                <div class="oo-empty-icon">

                                    <i class="bi bi-search"></i>

                                </div>

                                <h5>
                                    No Matching Orders
                                </h5>

                                <p>
                                    No orders match your current search
                                    and filter combination.
                                </p>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary mt-3"
                                    id="clearFiltersEmptyBtn"
                                >

                                    <i class="bi bi-x-circle me-1"></i>

                                    Clear Filters

                                </button>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($orders->hasPages())

            <div class="oo-pagination">

                {{ $orders->links() }}

            </div>

        @endif

    </div>

</div>


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       ELEMENTS
    ========================================================== */

    const searchInput =
        document.getElementById('orderSearch');

    const statusFilter =
        document.getElementById('statusFilter');

    const paymentFilter =
        document.getElementById('paymentFilter');

    const refreshOrdersBtn =
        document.getElementById('refreshOrdersBtn');

    const clearFiltersBtn =
        document.getElementById('clearFiltersBtn');

    const clearFiltersEmptyBtn =
        document.getElementById('clearFiltersEmptyBtn');

    const filterResultCount =
        document.getElementById('filterResultCount');

    const filterEmptyRow =
        document.getElementById('filterEmptyRow');

    const rows =
        document.querySelectorAll('.order-row');

    const quickFilters =
        document.querySelectorAll('.oo-quick-filter');


    /* =========================================================
       FILTER ORDERS
    ========================================================== */

    function filterOrders() {

        const searchTerm =
            searchInput
                ? searchInput.value
                    .toLowerCase()
                    .trim()
                : '';

        const selectedStatus =
            statusFilter
                ? statusFilter.value.toLowerCase()
                : '';

        const selectedPayment =
            paymentFilter
                ? paymentFilter.value.toLowerCase()
                : '';

        let visibleCount = 0;


        rows.forEach(function (row) {

            const searchableText =
                row.getAttribute('data-search') || '';

            const rowStatus =
                row.getAttribute('data-status') || '';

            const rowPayment =
                row.getAttribute('data-payment') || '';


            const matchesSearch =
                !searchTerm ||
                searchableText.includes(searchTerm);


            const matchesStatus =
                !selectedStatus ||
                rowStatus === selectedStatus;


            const matchesPayment =
                !selectedPayment ||
                rowPayment === selectedPayment;


            const shouldShow =
                matchesSearch &&
                matchesStatus &&
                matchesPayment;


            row.style.display =
                shouldShow ? '' : 'none';


            if (shouldShow) {
                visibleCount++;
            }

        });


        if (filterResultCount) {

            filterResultCount.textContent =
                'Showing ' +
                visibleCount +
                ' ' +
                (visibleCount === 1
                    ? 'order'
                    : 'orders');

        }


        if (filterEmptyRow) {

            filterEmptyRow.classList.toggle(
                'show',
                rows.length > 0 &&
                visibleCount === 0
            );

        }

    }


    /* =========================================================
       SEARCH
    ========================================================== */

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterOrders
        );

    }


    /* =========================================================
       STATUS FILTER
    ========================================================== */

    if (statusFilter) {

        statusFilter.addEventListener(
            'change',
            function () {

                updateQuickFilterState();

                filterOrders();

            }
        );

    }


    /* =========================================================
       PAYMENT FILTER
    ========================================================== */

    if (paymentFilter) {

        paymentFilter.addEventListener(
            'change',
            function () {

                updateQuickFilterState();

                filterOrders();

            }
        );

    }


    /* =========================================================
       QUICK FILTERS
    ========================================================== */

    quickFilters.forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const filter =
                    this.getAttribute(
                        'data-quick-filter'
                    ) || '';


                quickFilters.forEach(function (item) {

                    item.classList.remove(
                        'active'
                    );

                });


                this.classList.add('active');


                if (filter === 'not_paid') {

                    if (statusFilter) {
                        statusFilter.value = '';
                    }

                    if (paymentFilter) {
                        paymentFilter.value = 'not_paid';
                    }

                } else {

                    if (paymentFilter) {
                        paymentFilter.value = '';
                    }

                    if (statusFilter) {
                        statusFilter.value = filter;
                    }

                }


                filterOrders();

            }
        );

    });


    function updateQuickFilterState() {

        const status =
            statusFilter
                ? statusFilter.value
                : '';

        const payment =
            paymentFilter
                ? paymentFilter.value
                : '';


        quickFilters.forEach(function (button) {

            button.classList.remove(
                'active'
            );

            const filter =
                button.getAttribute(
                    'data-quick-filter'
                ) || '';


            if (
                filter === status &&
                !payment
            ) {

                button.classList.add(
                    'active'
                );

            }


            if (
                filter === 'not_paid' &&
                payment === 'not_paid'
            ) {

                button.classList.add(
                    'active'
                );

            }


            if (
                filter === '' &&
                !status &&
                !payment
            ) {

                button.classList.add(
                    'active'
                );

            }

        });

    }


    /* =========================================================
       CLEAR FILTERS
    ========================================================== */

    function clearFilters(event) {

        if (event) {
            event.preventDefault();
        }


        if (searchInput) {
            searchInput.value = '';
        }


        if (statusFilter) {
            statusFilter.value = '';
        }


        if (paymentFilter) {
            paymentFilter.value = '';
        }


        quickFilters.forEach(function (button) {

            button.classList.remove(
                'active'
            );

        });


        const allButton =
            document.querySelector(
                '.oo-quick-filter[data-quick-filter=""]'
            );


        if (allButton) {
            allButton.classList.add('active');
        }


        filterOrders();

    }


    if (clearFiltersBtn) {

        clearFiltersBtn.addEventListener(
            'click',
            clearFilters
        );

    }


    if (clearFiltersEmptyBtn) {

        clearFiltersEmptyBtn.addEventListener(
            'click',
            clearFilters
        );

    }


    /* =========================================================
       REFRESH
    ========================================================== */

    if (refreshOrdersBtn) {

        refreshOrdersBtn.addEventListener(
            'click',
            function () {

                this.disabled = true;

                this.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2"></span>' +
                    'Refreshing...';


                window.location.reload();

            }
        );

    }


    /* =========================================================
       CSRF
    ========================================================== */

    const csrfToken =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            ?.getAttribute('content');


    /* =========================================================
       PAYMENT SELECT APPEARANCE
    ========================================================== */

    function updatePaymentSelectAppearance(select) {

        const value =
            select.value === 'paid'
                ? 'paid'
                : 'not_paid';


        select.classList.remove(
            'status-paid',
            'status-not-paid'
        );


        select.classList.add(
            value === 'paid'
                ? 'status-paid'
                : 'status-not-paid'
        );

    }


    /* =========================================================
       PAYMENT MESSAGE
    ========================================================== */

    function showPaymentMessage(
        select,
        type
    ) {

        const wrapper =
            select.closest(
                '.oo-payment-control'
            );


        if (!wrapper) {
            return;
        }


        const saving =
            wrapper.querySelector(
                '.oo-payment-saving'
            );

        const saved =
            wrapper.querySelector(
                '.oo-payment-saved'
            );

        const error =
            wrapper.querySelector(
                '.oo-payment-error'
            );


        if (saving) {
            saving.classList.remove('show');
        }

        if (saved) {
            saved.classList.remove('show');
        }

        if (error) {
            error.classList.remove('show');
        }


        if (
            type === 'saving' &&
            saving
        ) {

            saving.classList.add('show');

        }


        if (
            type === 'saved' &&
            saved
        ) {

            saved.classList.add('show');


            setTimeout(function () {

                saved.classList.remove(
                    'show'
                );

            }, 2000);

        }


        if (
            type === 'error' &&
            error
        ) {

            error.classList.add('show');


            setTimeout(function () {

                error.classList.remove(
                    'show'
                );

            }, 3000);

        }

    }


    /* =========================================================
       PAYMENT STATUS UPDATE
    ========================================================== */

    document
        .querySelectorAll(
            '.oo-payment-select'
        )
        .forEach(function (select) {

            select.addEventListener(
                'change',
                async function () {

                    const paymentSelect =
                        this;


                    const newStatus =
                        paymentSelect.value === 'paid'
                            ? 'paid'
                            : 'not_paid';


                    const oldStatus =
                        paymentSelect.getAttribute(
                            'data-original-status'
                        ) || 'not_paid';


                    const paymentUrl =
                        paymentSelect.getAttribute(
                            'data-payment-url'
                        );


                    const orderNumber =
                        paymentSelect.getAttribute(
                            'data-order-number'
                        ) || '';


                    /*
                     * URL CHECK
                     */
                    if (!paymentUrl) {

                        paymentSelect.value =
                            oldStatus;

                        updatePaymentSelectAppearance(
                            paymentSelect
                        );

                        alert(
                            'Unable to update payment status because the update URL is missing.'
                        );

                        return;

                    }


                    /*
                     * CSRF CHECK
                     */
                    if (!csrfToken) {

                        paymentSelect.value =
                            oldStatus;

                        updatePaymentSelectAppearance(
                            paymentSelect
                        );

                        alert(
                            'Security token is missing. Please refresh the page and try again.'
                        );

                        return;

                    }


                    /*
                     * NO CHANGE
                     */
                    if (
                        newStatus ===
                        oldStatus
                    ) {

                        return;

                    }


                    /*
                     * DISABLE
                     */
                    paymentSelect.disabled =
                        true;

                    paymentSelect.classList.add(
                        'status-saving'
                    );


                    showPaymentMessage(
                        paymentSelect,
                        'saving'
                    );


                    try {

                        const response =
                            await fetch(
                                paymentUrl,
                                {
                                    method: 'PATCH',

                                    headers: {

                                        'Content-Type':
                                            'application/json',

                                        'Accept':
                                            'application/json',

                                        'X-CSRF-TOKEN':
                                            csrfToken,

                                        'X-Requested-With':
                                            'XMLHttpRequest'

                                    },

                                    body:
                                        JSON.stringify({

                                            payment_status:
                                                newStatus

                                        })

                                }
                            );


                        let data = {};


                        try {

                            data =
                                await response.json();

                        } catch (jsonError) {

                            data = {};

                        }


                        /*
                         * SERVER ERROR
                         */
                        if (!response.ok) {

                            throw new Error(
                                data.message ||
                                'Unable to update payment status.'
                            );

                        }


                        /*
                         * SUCCESS
                         */

                        paymentSelect.setAttribute(
                            'data-original-status',
                            newStatus
                        );


                        const row =
                            paymentSelect.closest(
                                '.order-row'
                            );


                        if (row) {

                            row.setAttribute(
                                'data-payment',
                                newStatus
                            );

                        }


                        updatePaymentSelectAppearance(
                            paymentSelect
                        );


                        showPaymentMessage(
                            paymentSelect,
                            'saved'
                        );


                        /*
                         * Re-run active filters.
                         */
                        filterOrders();


                    } catch (error) {

                        console.error(
                            'Payment status update error:',
                            error
                        );


                        /*
                         * Revert UI.
                         */
                        paymentSelect.value =
                            oldStatus;


                        updatePaymentSelectAppearance(
                            paymentSelect
                        );


                        showPaymentMessage(
                            paymentSelect,
                            'error'
                        );


                        alert(
                            error.message ||
                            'Payment status could not be updated. Please try again.'
                        );


                    } finally {

                        paymentSelect.disabled =
                            false;

                        paymentSelect.classList.remove(
                            'status-saving'
                        );

                    }

                }
            );


            /*
             * Initial appearance.
             */
            updatePaymentSelectAppearance(
                select
            );

        });


    /* =========================================================
       INITIAL FILTER
    ========================================================== */

    filterOrders();

});
</script>

@endpush

@endsection