
<x-layout>
    @section('title', 'Dashboard Overview')

    @section('content')

    @php
        /*
        |--------------------------------------------------------------------------
        | Safe dashboard defaults
        |--------------------------------------------------------------------------
        | The controller should provide combined figures from Order and
        | OnlineOrder. Defaults prevent undefined-variable errors.
        */
        $todaySales = $todaySales ?? 0;
        $totalOrders = $totalOrders ?? 0;
        $pendingOrders = $pendingOrders ?? 0;
        $readyOrders = $readyOrders ?? 0;
        $allOrders = $allOrders ?? 0;
        $walkInOrdersToday = $walkInOrdersToday ?? 0;
        $onlineOrdersToday = $onlineOrdersToday ?? 0;
        $recentOrders = $recentOrders ?? collect();
        $salesData = $salesData ?? collect();

        $salesLabels = $salesData instanceof \Illuminate\Support\Collection
            ? $salesData->keys()->values()
            : collect(array_keys((array) $salesData));

        $salesValues = $salesData instanceof \Illuminate\Support\Collection
            ? $salesData->values()
            : collect(array_values((array) $salesData));
    @endphp

    <style>
        :root {
            --sw-primary: #0d6efd;
            --sw-primary-dark: #084298;
            --sw-deep: #062b68;
            --sw-light: #eaf3ff;
            --sw-body: #f5f8fc;
            --sw-white: #fff;
            --sw-text: #10233f;
            --sw-muted: #6b7a90;
            --sw-border: #e5ebf3;
            --sw-shadow: 0 8px 28px rgba(16,35,63,.055);
            --sw-shadow-hover: 0 16px 38px rgba(13,110,253,.12);
            --sw-radius: 18px;
        }

        .smartwash-dashboard {
            min-height: 100vh;
            color: var(--sw-text);
            background:
                radial-gradient(circle at 95% 0%, rgba(13,110,253,.07), transparent 28%),
                var(--sw-body);
            padding-bottom: 0;
        }

        .dashboard-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .dashboard-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--sw-primary);
            background: var(--sw-light);
            border: 1px solid #d7e7ff;
            border-radius: 999px;
            padding: 6px 11px;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        .dashboard-heading h1 {
            color: var(--sw-text);
            font-size: clamp(1.45rem, 2.3vw, 2rem);
            font-weight: 850;
            letter-spacing: -.7px;
            margin: 12px 0 5px;
        }

        .dashboard-heading p {
            color: var(--sw-muted);
            margin: 0;
            font-size: .9rem;
        }

        .today-date {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 11px 14px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid var(--sw-border);
            color: var(--sw-muted);
            box-shadow: var(--sw-shadow);
            font-size: .82rem;
            font-weight: 700;
        }

        .top-action-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 14px;
            margin-bottom: 24px;
            border: 1px solid rgba(13,110,253,.09);
            border-radius: var(--sw-radius);
            background: rgba(255,255,255,.96);
            box-shadow: var(--sw-shadow);
        }

        .top-action-bar .btn {
            flex: 1 1 auto;
            min-height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 15px;
            border-radius: 11px;
            font-size: .84rem;
            font-weight: 750;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .top-action-bar .btn:hover {
            transform: translateY(-2px);
        }

        .top-action-bar .btn-primary,
        .btn-action.btn-primary {
            color: #fff;
            background: linear-gradient(135deg, #0d6efd, #084298);
            border-color: #0d6efd;
            box-shadow: 0 7px 18px rgba(13,110,253,.18);
        }

        .top-action-bar .btn-outline-primary {
            color: #0d6efd;
            background: #eaf3ff;
            border-color: #cfe1ff;
        }

        .top-action-bar .btn-outline-warning {
            color: #92400e;
            background: #fff8eb;
            border-color: #fed7aa;
        }

        .top-action-bar .btn-outline-success {
            color: #166534;
            background: #f0fdf4;
            border-color: #bbf7d0;
        }

        .top-action-bar .btn-outline-info {
            color: #075985;
            background: #f0f9ff;
            border-color: #bae6fd;
        }

        .stat-card {
            position: relative;
            isolation: isolate;
            min-height: 158px;
            overflow: hidden;
            border: 0;
            border-radius: var(--sw-radius);
            color: #fff;
            box-shadow: var(--sw-shadow);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--sw-shadow-hover);
        }

        .stat-card::before,
        .stat-card::after {
            position: absolute;
            content: "";
            z-index: -1;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }

        .stat-card::before {
            width: 185px;
            height: 185px;
            top: -88px;
            right: -55px;
        }

        .stat-card::after {
            width: 100px;
            height: 100px;
            bottom: -65px;
            right: 65px;
            background: rgba(255,255,255,.045);
        }

        .stat-blue { background: linear-gradient(135deg,#0d6efd,#084298); }
        .stat-navy { background: linear-gradient(135deg,#1554a6,#082d68); }
        .stat-sky { background: linear-gradient(135deg,#2196f3,#0750ad); }
        .stat-indigo { background: linear-gradient(135deg,#3266d5,#203b91); }
        .stat-teal { background: linear-gradient(135deg,#147dba,#075985); }

        .stat-icon {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 16px;
            background: rgba(255,255,255,.14);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.15);
            backdrop-filter: blur(8px);
        }

        .stat-icon i { font-size: 1.45rem; }

        .stat-label {
            display: block;
            color: rgba(255,255,255,.78);
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        .stat-value {
            margin-top: 7px;
            color: #fff;
            font-size: clamp(1.3rem, 2vw, 1.8rem);
            font-weight: 850;
            line-height: 1.15;
            overflow-wrap: anywhere;
        }

        .stat-note {
            margin-top: 8px;
            color: rgba(255,255,255,.76);
            font-size: .72rem;
        }

        .source-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .source-tile {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
            padding: 17px;
            border: 1px solid var(--sw-border);
            border-radius: 15px;
            background: #fff;
            box-shadow: var(--sw-shadow);
        }

        .source-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 43px;
            height: 43px;
            border-radius: 12px;
            color: var(--sw-primary);
            background: var(--sw-light);
            font-size: 1.1rem;
        }

        .source-tile small {
            display: block;
            margin-bottom: 3px;
            color: var(--sw-muted);
            font-size: .72rem;
            font-weight: 750;
        }

        .source-tile strong {
            display: block;
            color: var(--sw-text);
            font-size: 1.3rem;
            font-weight: 850;
        }

        .content-card {
            height: 100%;
            overflow: hidden;
            border: 1px solid var(--sw-border);
            border-radius: var(--sw-radius);
            background: #fff;
            box-shadow: var(--sw-shadow);
        }

        .content-card .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 18px 21px;
            border-bottom: 1px solid var(--sw-border);
            background: #fff;
        }

        .card-title {
            margin: 0;
            color: var(--sw-text);
            font-size: .95rem;
            font-weight: 850;
        }

        .card-title i {
            margin-right: 8px;
            color: var(--sw-primary);
        }

        .card-subtitle {
            margin-top: 5px;
            color: var(--sw-muted);
            font-size: .76rem;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 315px;
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 49px;
            border-radius: 11px;
            font-size: .86rem;
            font-weight: 750;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .btn-action:hover { transform: translateY(-2px); }

        .btn-action.btn-outline-secondary {
            color: var(--sw-primary);
            background: #f4f8ff;
            border-color: #d3e2f7;
        }

        .quick-action-note {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 20px;
            padding: 13px;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            background: #f5f9ff;
            color: #526780;
            font-size: .78rem;
            line-height: 1.55;
        }

        .quick-action-note i {
            margin-top: 2px;
            color: var(--sw-primary);
        }

        .table-responsive { min-height: 130px; }

        .modern-table { margin: 0; }

        .modern-table thead th {
            padding: 14px 16px;
            border-bottom: 1px solid var(--sw-border);
            background: linear-gradient(180deg,#f8fbff,#f1f6fc);
            color: #62728a;
            font-size: .69rem;
            font-weight: 850;
            letter-spacing: .65px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .modern-table tbody td {
            padding: 15px 16px;
            border-color: #edf1f6;
            color: #34465f;
            font-size: .82rem;
            vertical-align: middle;
        }

        .modern-table tbody tr:hover { background: #f6faff; }

        .order-number {
            color: var(--sw-primary-dark);
            font-weight: 850;
            white-space: nowrap;
        }

        .customer-name {
            color: var(--sw-text);
            font-weight: 750;
        }

        .customer-subtitle {
            display: block;
            margin-top: 3px;
            color: var(--sw-muted);
            font-size: .72rem;
        }

        .source-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 9px;
            border: 1px solid #dbeafe;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: .7rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .source-badge.online {
            color: #075985;
            background: #f0f9ff;
            border-color: #bae6fd;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: .71rem;
            font-weight: 850;
            white-space: nowrap;
        }

        .status-pending {
            color: #92400e;
            background: #fff7ed;
            border-color: #fed7aa;
        }

        .status-processing {
            color: #075985;
            background: #e0f2fe;
            border-color: #bae6fd;
        }

        .status-ready {
            color: #6b21a8;
            background: #faf5ff;
            border-color: #e9d5ff;
        }

        .status-completed,
        .status-delivered {
            color: #166534;
            background: #dcfce7;
            border-color: #bbf7d0;
        }

        .status-cancelled {
            color: #991b1b;
            background: #fef2f2;
            border-color: #fecaca;
        }

        .status-info {
            color: #334155;
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        .receipt-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 7px 10px;
            border: 1px solid #d7e4f7;
            border-radius: 9px;
            background: #f1f6ff;
            color: var(--sw-primary);
            font-size: .73rem;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
            transition: all .2s ease;
        }

        .receipt-btn:hover {
            transform: translateY(-1px);
            border-color: var(--sw-primary);
            background: var(--sw-primary);
            color: #fff;
        }

        .smartwash-footer {
            position: relative;
            overflow: hidden;
            margin-top: 30px;
            color: #fff;
            background: linear-gradient(135deg,#061d45,#082f6b 55%,#0d6efd);
        }

        .footer-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            padding: 25px 28px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #fff;
            color: var(--sw-primary);
            font-size: 1.2rem;
        }

        .footer-brand-title {
            margin: 0;
            font-size: .94rem;
            font-weight: 850;
        }

        .footer-brand-subtitle,
        .footer-copy {
            margin: 3px 0 0;
            color: rgba(255,255,255,.68);
            font-size: .73rem;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 17px;
        }

        .footer-links a {
            color: rgba(255,255,255,.8);
            font-size: .75rem;
            font-weight: 700;
            text-decoration: none;
        }

        .footer-links a:hover { color: #fff; }

        @media (max-width: 1199px) {
            .stat-card { min-height: 145px; }
            .stat-icon { width: 52px; height: 52px; }
        }

        @media (max-width: 767px) {
            .smartwash-dashboard { padding-left: 5px; padding-right: 5px; }
            .top-action-bar { padding: 10px; }
            .top-action-bar .btn { flex: 1 1 100%; }
            .source-summary { grid-template-columns: 1fr; gap: 10px; }
            .source-tile { padding: 13px; }
            .chart-container { height: 260px; }
            .content-card .card-header { padding: 15px; }
            .modern-table thead th,
            .modern-table tbody td { padding: 12px; }
            .footer-inner { justify-content: center; text-align: center; }
            .footer-brand { justify-content: center; width: 100%; }
            .footer-copy { width: 100%; }
            .footer-links { justify-content: center; width: 100%; }
        }

        @media (prefers-reduced-motion: reduce) {
            .stat-card,
            .top-action-bar .btn,
            .btn-action,
            .receipt-btn {
                transition: none;
            }
        }
    </style>

    <div class="smartwash-dashboard">
        <div class="container-fluid pt-4">

            {{-- PAGE HEADING --}}
            <div class="dashboard-heading">
                <div>
                    <span class="dashboard-eyebrow">
                        <i class="bi bi-stars"></i>
                        SmartWash Management
                    </span>

                    <h1>Dashboard Overview</h1>

                    <p>
                        Monitor laundry operations, online orders, walk-in sales
                        and order progress from one place.
                    </p>
                </div>

                <div class="today-date">
                    <i class="bi bi-calendar3 text-primary"></i>
                    {{ now()->format('D, d M Y') }}
                </div>
            </div>

            {{-- TOP ACTIONS --}}
            <div class="top-action-bar">
                <a href="{{ route('pos.index') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    New Walk-in Order
                </a>

                <a href="{{ route('orders.index', ['filter' => 'today']) }}"
                   class="btn btn-outline-primary">
                    <i class="bi bi-calendar-day"></i>
                    Today's Orders
                </a>

                <a href="{{ route('orders.index', ['filter' => 'pending']) }}"
                   class="btn btn-outline-warning">
                    <i class="bi bi-hourglass-split"></i>
                    Pending Orders
                </a>

                <a href="{{ route('orders.index', ['filter' => 'completed']) }}"
                   class="btn btn-outline-success">
                    <i class="bi bi-check-circle"></i>
                    Completed Orders
                </a>

                <a href="{{ route('sales.monthly') }}"
                   class="btn btn-outline-info">
                    <i class="bi bi-graph-up-arrow"></i>
                    Sales Reports
                </a>
            </div>

            {{-- PRIMARY STATISTICS --}}
            <div class="row mb-4">

                <div class="col-xl col-lg-4 col-md-6 mb-3">
                    <div class="card stat-card stat-blue h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon me-3">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div class="position-relative">
                                <span class="stat-label">Today's Sales</span>
                                <div class="stat-value">
                                    KSh {{ number_format((float) $todaySales, 2) }}
                                </div>
                                <div class="stat-note">Combined order revenue</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl col-lg-4 col-md-6 mb-3">
                    <div class="card stat-card stat-navy h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon me-3">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <div class="position-relative">
                                <span class="stat-label">All Orders</span>
                                <div class="stat-value">
                                    {{ number_format((int) $allOrders) }}
                                </div>
                                <div class="stat-note">Walk-in + online, all time</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl col-lg-4 col-md-6 mb-3">
                    <div class="card stat-card stat-sky h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon me-3">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="position-relative">
                                <span class="stat-label">Today's Orders</span>
                                <div class="stat-value">
                                    {{ number_format((int) $totalOrders) }}
                                </div>
                                <div class="stat-note">Orders received today</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl col-lg-6 col-md-6 mb-3">
                    <div class="card stat-card stat-indigo h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon me-3">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="position-relative">
                                <span class="stat-label">Pending</span>
                                <div class="stat-value">
                                    {{ number_format((int) $pendingOrders) }}
                                </div>
                                <div class="stat-note">Awaiting processing</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl col-lg-6 col-md-6 mb-3">
                    <div class="card stat-card stat-teal h-100">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="stat-icon me-3">
                                <i class="bi bi-bell"></i>
                            </div>
                            <div class="position-relative">
                                <span class="stat-label">Ready</span>
                                <div class="stat-value">
                                    {{ number_format((int) $readyOrders) }}
                                </div>
                                <div class="stat-note">Ready for collection</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ORDER SOURCE BREAKDOWN --}}
            <div class="source-summary">
                <div class="source-tile">
                    <div class="source-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div>
                        <small>Walk-in Orders Today</small>
                        <strong>{{ number_format((int) $walkInOrdersToday) }}</strong>
                    </div>
                </div>

                <div class="source-tile">
                    <div class="source-icon">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <div>
                        <small>Online Orders Today</small>
                        <strong>{{ number_format((int) $onlineOrdersToday) }}</strong>
                    </div>
                </div>

                <div class="source-tile">
                    <div class="source-icon">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <div>
                        <small>Order Channels</small>
                        <strong>2 Channels</strong>
                    </div>
                </div>
            </div>

            {{-- SALES CHART + QUICK ACTIONS --}}
            <div class="row mb-4">

                <div class="col-xl-8 col-lg-7 mb-4 mb-xl-0">
                    <div class="card content-card">
                        <div class="card-header">
                            <div>
                                <h6 class="card-title">
                                    <i class="bi bi-graph-up-arrow"></i>
                                    Earnings Overview
                                </h6>
                                <div class="card-subtitle">
                                    Combined sales activity over the last seven days
                                </div>
                            </div>

                            <span class="badge rounded-pill px-3 py-2"
                                  style="background:#eaf3ff;color:#0d6efd;">
                                <i class="bi bi-calendar-week me-1"></i>
                                Last 7 Days
                            </span>
                        </div>

                        <div class="card-body p-3 p-md-4">
                            <div class="chart-container">
                                <canvas id="salesChart"
                                        role="img"
                                        aria-label="Sales chart for the last seven days">
                                    Sales chart
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5">
                    <div class="card content-card">
                        <div class="card-header">
                            <div>
                                <h6 class="card-title">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                    Quick Actions
                                </h6>
                                <div class="card-subtitle">
                                    Common operational tasks
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <a href="{{ route('pos.index') }}"
                               class="btn btn-action btn-primary w-100 mb-3">
                                <i class="bi bi-plus-circle me-2"></i>
                                Create Walk-in Order
                            </a>

                            <a href="{{ route('orders.index') }}"
                               class="btn btn-action btn-outline-secondary w-100 mb-3">
                                <i class="bi bi-list-ul me-2"></i>
                                Manage Orders
                            </a>

                            <a href="{{ route('sales.monthly') }}"
                               class="btn btn-action btn-outline-secondary w-100">
                                <i class="bi bi-bar-chart-line me-2"></i>
                                View Sales Reports
                            </a>

                            <div class="quick-action-note">
                                <i class="bi bi-info-circle-fill"></i>
                                <div>
                                    <strong>Unified overview</strong><br>
                                    Walk-in and online orders appear together in
                                    the dashboard. Their individual order records
                                    remain in their respective systems.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RECENT COMBINED ORDERS --}}
            <div class="row">
                <div class="col-12">
                    <div class="card content-card">

                        <div class="card-header">
                            <div>
                                <h6 class="card-title">
                                    <i class="bi bi-clock-history"></i>
                                    Recent Orders
                                </h6>
                                <div class="card-subtitle">
                                    Latest walk-in and online orders, sorted by date
                                </div>
                            </div>

                            <a href="{{ route('orders.index') }}"
                               class="small text-decoration-none fw-bold"
                               style="color:#0d6efd;">
                                Manage Orders
                                <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover modern-table">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Source</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Date Received</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($recentOrders as $order)
                                            @php
                                                $status = strtolower(
                                                    trim((string) ($order->status ?? 'pending'))
                                                );

                                                $statusClass = match ($status) {
                                                    'pending' => 'status-pending',
                                                    'processing' => 'status-processing',
                                                    'ready' => 'status-ready',
                                                    'completed' => 'status-completed',
                                                    'delivered' => 'status-delivered',
                                                    'cancelled' => 'status-cancelled',
                                                    default => 'status-info',
                                                };

                                                $statusIcon = match ($status) {
                                                    'pending' => 'bi-hourglass-split',
                                                    'processing' => 'bi-arrow-repeat',
                                                    'ready' => 'bi-bell',
                                                    'completed', 'delivered' => 'bi-check-circle-fill',
                                                    'cancelled' => 'bi-x-circle-fill',
                                                    default => 'bi-circle-fill',
                                                };

                                                $sourceType = $order->source_type ?? 'walk_in';
                                                $isOnline = $sourceType === 'online';

                                                $orderNumber = $order->display_number
                                                    ?? $order->order_number
                                                    ?? $order->invoice_no
                                                    ?? (($isOnline ? 'WEB-' : 'POS-') . $order->id);

                                                $customerName = $order->customer_name
                                                    ?? ($isOnline ? 'Online Customer' : 'Walk-in Customer');
                                            @endphp

                                            <tr>
                                                <td>
                                                    <span class="order-number">
                                                        {{ $orderNumber }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if($isOnline)
                                                        <span class="source-badge online">
                                                            <i class="bi bi-globe2"></i>
                                                            Online
                                                        </span>
                                                    @else
                                                        <span class="source-badge">
                                                            <i class="bi bi-shop"></i>
                                                            Walk-in
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <span class="customer-name">
                                                        {{ $customerName }}
                                                    </span>

                                                    @if($isOnline && !empty($order->phone))
                                                        <span class="customer-subtitle">
                                                            {{ $order->phone }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <strong style="color:#10233f;white-space:nowrap;">
                                                        KSh {{ number_format((float) ($order->total_amount ?? 0), 2) }}
                                                    </strong>
                                                </td>

                                                <td>
                                                    <span class="status-badge {{ $statusClass }}">
                                                        <i class="bi {{ $statusIcon }}"></i>
                                                        {{ ucfirst($status) }}
                                                    </span>
                                                </td>

                                                <td style="white-space:nowrap;">
                                                    <div class="fw-semibold">
                                                        {{ $order->created_at?->format('d M Y') ?? '—' }}
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $order->created_at?->format('h:i A') ?? '' }}
                                                    </small>
                                                </td>

                                                <td>
                                                    @if(!$isOnline)
                                                        <a href="{{ route('pos.receipt', $order->id) }}"
                                                           class="receipt-btn"
                                                           target="_blank"
                                                           rel="noopener noreferrer">
                                                            <i class="bi bi-receipt"></i>
                                                            Receipt
                                                        </a>
                                                    @else
                                                        <span class="text-muted small">
                                                            <i class="bi bi-globe2 me-1"></i>
                                                            Online order
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="mb-3">
                                                        <i class="bi bi-inbox"
                                                           style="font-size:3rem;color:#cbd5e1;"></i>
                                                    </div>

                                                    <div class="fw-bold" style="color:#475569;">
                                                        No recent orders found
                                                    </div>

                                                    <div class="small text-muted mt-1">
                                                        Walk-in and online orders will appear here
                                                        when the dashboard controller supplies them.
                                                    </div>

                                                    <a href="{{ route('pos.index') }}"
                                                       class="btn btn-primary btn-sm mt-3">
                                                        <i class="bi bi-plus-circle me-1"></i>
                                                        Create First Order
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if(method_exists($recentOrders, 'count') && $recentOrders->count() > 0)
                            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2"
                                 style="background:#fff;border-top:1px solid #e5ebf3;">
                                <span class="small text-muted">
                                    Showing {{ $recentOrders->count() }} recent combined orders
                                </span>

                                <a href="{{ route('orders.index') }}"
                                   class="small fw-bold text-decoration-none"
                                   style="color:#0d6efd;">
                                    View order management
                                    <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>

       
    </div>

    @endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const canvas = document.getElementById('salesChart');

                if (!canvas || typeof Chart === 'undefined') {
                    return;
                }

                const labels = @json($salesLabels);
                const values = @json($salesValues);

                if (canvas.chartInstance) {
                    canvas.chartInstance.destroy();
                }

                const ctx = canvas.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 315);

                gradient.addColorStop(0, 'rgba(13, 110, 253, 0.24)');
                gradient.addColorStop(1, 'rgba(13, 110, 253, 0.01)');

                canvas.chartInstance = new Chart(ctx, {
                    type: 'line',

                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Sales (KSh)',
                            data: values,
                            backgroundColor: gradient,
                            borderColor: '#0d6efd',
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#0d6efd',
                            pointHoverBackgroundColor: '#0d6efd',
                            pointHoverBorderColor: '#ffffff',
                            borderWidth: 3,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBorderWidth: 2,
                            tension: 0.4,
                            fill: true
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },

                        plugins: {
                            legend: {
                                display: false
                            },

                            tooltip: {
                                backgroundColor: '#062b68',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                padding: 12,
                                cornerRadius: 10,
                                displayColors: false,

                                callbacks: {
                                    label: function (context) {
                                        return 'KSh ' +
                                            Number(context.parsed.y || 0).toLocaleString(
                                                'en-KE',
                                                {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                }
                                            );
                                    }
                                }
                            }
                        },

                        scales: {
                            y: {
                                beginAtZero: true,
                                border: {
                                    display: false
                                },
                                grid: {
                                    color: 'rgba(226, 232, 240, 0.75)',
                                    drawTicks: false
                                },
                                ticks: {
                                    padding: 10,
                                    color: '#718096',

                                    callback: function (value) {
                                        return 'KSh ' +
                                            Number(value).toLocaleString('en-KE');
                                    },

                                    font: {
                                        family: "'Segoe UI', sans-serif",
                                        size: 11
                                    }
                                }
                            },

                            x: {
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#718096',
                                    padding: 8,
                                    maxRotation: 0,

                                    font: {
                                        family: "'Segoe UI', sans-serif",
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

</x-layout>

