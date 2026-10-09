<x-layout>

    @section('title', 'Dashboard Overview')

    @section('content')

        <style>
            /* ================================================================
               SMARTWASH PREMIUM BLUE & WHITE DASHBOARD
            ================================================================ */

            :root {
                --sw-primary: #0d6efd;
                --sw-primary-dark: #084298;
                --sw-primary-deep: #062b68;
                --sw-primary-light: #eaf3ff;
                --sw-blue-soft: #f4f8ff;

                --sw-white: #ffffff;
                --sw-surface: #ffffff;
                --sw-body: #f5f8fc;

                --sw-text: #10233f;
                --sw-muted: #6b7a90;
                --sw-border: #e5ebf3;

                --sw-success: #16a34a;
                --sw-warning: #f59e0b;
                --sw-danger: #dc3545;

                --sw-shadow: 0 8px 30px rgba(16, 35, 63, 0.06);
                --sw-shadow-hover: 0 18px 45px rgba(13, 110, 253, 0.13);

                --sw-radius: 18px;
            }


            /* ================================================================
               PAGE
            ================================================================ */

            .smartwash-dashboard {
                background:
                    radial-gradient(
                        circle at top right,
                        rgba(13, 110, 253, 0.055),
                        transparent 30%
                    ),
                    var(--sw-body);

                min-height: 100vh;
                color: var(--sw-text);
                padding-bottom: 0;
            }


            /* ================================================================
               TOP ACTION BAR
            ================================================================ */

            .top-action-bar {
                background: rgba(255, 255, 255, 0.96);
                border: 1px solid rgba(13, 110, 253, 0.08);
                border-radius: var(--sw-radius);
                padding: 14px;
                margin-bottom: 24px;

                display: flex;
                flex-wrap: wrap;
                gap: 10px;

                box-shadow: var(--sw-shadow);

                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }

            .top-action-bar .btn {
                flex: 1 1 auto;
                min-height: 46px;

                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 7px;

                border-radius: 11px;

                font-size: 0.86rem;
                font-weight: 700;

                padding: 10px 16px;

                transition:
                    transform 0.2s ease,
                    box-shadow 0.2s ease,
                    background 0.2s ease;
            }

            .top-action-bar .btn:hover {
                transform: translateY(-2px);
            }

            .top-action-bar .btn-primary {
                background: linear-gradient(
                    135deg,
                    var(--sw-primary),
                    var(--sw-primary-dark)
                );

                border-color: var(--sw-primary);

                box-shadow:
                    0 8px 20px rgba(13, 110, 253, 0.22);
            }

            .top-action-bar .btn-outline-primary {
                color: var(--sw-primary);
                border-color: rgba(13, 110, 253, 0.28);
                background: var(--sw-primary-light);
            }

            .top-action-bar .btn-outline-primary:hover {
                background: var(--sw-primary);
                color: #fff;
            }

            .top-action-bar .btn-outline-warning {
                color: #9a6700;
                border-color: rgba(245, 158, 11, 0.25);
                background: #fffaf0;
            }

            .top-action-bar .btn-outline-warning:hover {
                color: #fff;
                background: #f59e0b;
                border-color: #f59e0b;
            }

            .top-action-bar .btn-outline-success {
                color: #15803d;
                border-color: rgba(22, 163, 74, 0.22);
                background: #f0fdf4;
            }

            .top-action-bar .btn-outline-success:hover {
                color: #fff;
                background: #16a34a;
                border-color: #16a34a;
            }

            .top-action-bar .btn-outline-info {
                color: #075985;
                border-color: rgba(14, 165, 233, 0.22);
                background: #f0f9ff;
            }

            .top-action-bar .btn-outline-info:hover {
                color: #fff;
                background: #0284c7;
                border-color: #0284c7;
            }


            /* ================================================================
               STAT CARDS
            ================================================================ */

            .modern-card {
                border: 0;
                border-radius: var(--sw-radius);
                overflow: hidden;
                position: relative;

                box-shadow: var(--sw-shadow);

                transition:
                    transform 0.25s ease,
                    box-shadow 0.25s ease;
            }

            .modern-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--sw-shadow-hover);
            }

            .stat-card {
                min-height: 155px;
                isolation: isolate;
            }

            .stat-card::before {
                content: "";

                position: absolute;

                width: 190px;
                height: 190px;

                right: -70px;
                top: -85px;

                border-radius: 50%;

                background: rgba(255, 255, 255, 0.09);

                z-index: -1;
            }

            .stat-card::after {
                content: "";

                position: absolute;

                width: 100px;
                height: 100px;

                right: 45px;
                bottom: -70px;

                border-radius: 50%;

                background: rgba(255, 255, 255, 0.05);

                z-index: -1;
            }


            /* ================================================================
               BLUE STAT VARIANTS
            ================================================================ */

            .bg-gradient-primary,
            .bg-gradient-success,
            .bg-gradient-warning,
            .bg-gradient-info {
                color: #fff !important;

                background:
                    linear-gradient(
                        135deg,
                        #0d6efd 0%,
                        #084298 100%
                    ) !important;
            }

            .stat-card:nth-child(2) .bg-gradient-success {
                background:
                    linear-gradient(
                        135deg,
                        #1261c9 0%,
                        #0a3f8f 100%
                    ) !important;
            }

            .stat-card:nth-child(3) .bg-gradient-warning {
                background:
                    linear-gradient(
                        135deg,
                        #1976e8 0%,
                        #0750ad 100%
                    ) !important;
            }

            .stat-card:nth-child(4) .bg-gradient-info {
                background:
                    linear-gradient(
                        135deg,
                        #2196f3 0%,
                        #0b5fc2 100%
                    ) !important;
            }

            .stat-icon {
                width: 62px;
                height: 62px;

                flex-shrink: 0;

                display: flex;
                align-items: center;
                justify-content: center;

                border-radius: 17px;

                background: rgba(255, 255, 255, 0.15);

                border: 1px solid rgba(255, 255, 255, 0.18);

                box-shadow:
                    inset 0 1px 0 rgba(255, 255, 255, 0.18),
                    0 8px 20px rgba(0, 0, 0, 0.08);

                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);

                z-index: 1;
            }

            .stat-icon i {
                font-size: 1.45rem;
            }

            .stat-label {
                display: block;

                color: rgba(255, 255, 255, 0.72);

                font-size: 0.72rem;
                font-weight: 700;

                text-transform: uppercase;
                letter-spacing: 0.8px;
            }

            .stat-value {
                color: #fff;

                font-size: 1.7rem;
                line-height: 1.2;

                font-weight: 800;

                margin-top: 5px;
            }


            /* ================================================================
               CONTENT CARDS
            ================================================================ */

            .content-card {
                background: var(--sw-surface);

                border: 1px solid var(--sw-border);

                border-radius: var(--sw-radius);

                box-shadow: var(--sw-shadow);

                overflow: hidden;

                transition:
                    box-shadow 0.25s ease,
                    transform 0.25s ease;
            }

            .content-card:hover {
                box-shadow:
                    0 14px 38px rgba(16, 35, 63, 0.08);
            }

            .content-card .card-header {
                background: #fff;

                border-bottom: 1px solid var(--sw-border);

                padding: 18px 22px;
            }

            .content-card .card-title {
                color: var(--sw-text);

                font-size: 0.96rem;
                font-weight: 800;

                margin: 0;
            }

            .content-card .card-title i {
                color: var(--sw-primary);
            }


            /* ================================================================
               QUICK ACTIONS
            ================================================================ */

            .btn-action {
                min-height: 50px;

                border-radius: 12px;

                display: flex;
                align-items: center;
                justify-content: center;

                font-weight: 700;
                font-size: 0.9rem;

                transition:
                    transform 0.2s ease,
                    box-shadow 0.2s ease;
            }

            .btn-action:hover {
                transform: translateY(-2px);
            }

            .btn-action.btn-primary {
                background:
                    linear-gradient(
                        135deg,
                        var(--sw-primary),
                        var(--sw-primary-dark)
                    );

                border-color: var(--sw-primary);

                box-shadow:
                    0 8px 20px rgba(13, 110, 253, 0.2);
            }

            .btn-action.btn-outline-secondary {
                color: var(--sw-primary);
                border-color: #cbd9ed;
                background: var(--sw-blue-soft);
            }

            .btn-action.btn-outline-secondary:hover {
                color: #fff;
                background: var(--sw-primary);
                border-color: var(--sw-primary);
            }


            /* ================================================================
               TABLE
            ================================================================ */

            .modern-table {
                margin: 0;
            }

            .modern-table thead th {
                background:
                    linear-gradient(
                        180deg,
                        #f8fbff,
                        #f3f7fc
                    );

                color: #62728a;

                font-size: 0.72rem;
                font-weight: 800;

                text-transform: uppercase;
                letter-spacing: 0.7px;

                border-bottom: 1px solid var(--sw-border);

                padding: 15px 18px;

                white-space: nowrap;
            }

            .modern-table tbody td {
                color: #34465f;

                font-size: 0.87rem;

                padding: 16px 18px;

                border-color: #edf1f6;

                vertical-align: middle;
            }

            .modern-table tbody tr {
                transition:
                    background 0.2s ease,
                    transform 0.2s ease;
            }

            .modern-table tbody tr:hover {
                background: #f6faff;
            }

            .modern-table tbody td strong {
                color: var(--sw-primary-dark);
                font-weight: 800;
            }


            /* ================================================================
               STATUS BADGES
               EACH ORDER STATUS HAS ITS OWN COLOR
            ================================================================ */

            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 7px;

                padding: 7px 12px;

                border-radius: 999px;

                font-size: 0.74rem;
                font-weight: 800;

                white-space: nowrap;

                border: 1px solid transparent;
            }

            .status-badge i {
                font-size: 0.48rem;
            }


            /* PENDING - AMBER */

            .status-pending {
                color: #92400e;
                background: #fff7ed;
                border-color: #fed7aa;

                box-shadow:
                    0 3px 10px rgba(245, 158, 11, 0.08);
            }

            .status-pending i {
                color: #f59e0b;
            }


            /* PROCESSING - BLUE */

            .status-processing {
                color: #075985;
                background: #e0f2fe;
                border-color: #bae6fd;

                box-shadow:
                    0 3px 10px rgba(14, 165, 233, 0.08);
            }

            .status-processing i {
                color: #0284c7;
            }


            /* READY - PURPLE */

            .status-ready {
                color: #6b21a8;
                background: #faf5ff;
                border-color: #e9d5ff;

                box-shadow:
                    0 3px 10px rgba(147, 51, 234, 0.08);
            }

            .status-ready i {
                color: #9333ea;
            }


            /* DELIVERED - GREEN */

            .status-delivered {
                color: #166534;
                background: #dcfce7;
                border-color: #bbf7d0;

                box-shadow:
                    0 3px 10px rgba(22, 163, 74, 0.08);
            }

            .status-delivered i {
                color: #16a34a;
            }


            /* CANCELLED - RED */

            .status-cancelled {
                color: #991b1b;
                background: #fef2f2;
                border-color: #fecaca;

                box-shadow:
                    0 3px 10px rgba(220, 53, 69, 0.08);
            }

            .status-cancelled i {
                color: #dc3545;
            }


            /* FALLBACK / OTHER STATUS */

            .status-info {
                color: #334155;
                background: #f1f5f9;
                border-color: #e2e8f0;
            }

            .status-info i {
                color: #64748b;
            }


            /* ================================================================
               RECEIPT BUTTON
            ================================================================ */

            .receipt-btn {
                border-radius: 9px;

                color: var(--sw-primary);

                background: #f1f6ff;

                border: 1px solid #d7e4f7;

                font-size: 0.76rem;
                font-weight: 700;

                padding: 7px 12px;

                transition: all 0.2s ease;
            }

            .receipt-btn:hover {
                color: #fff;

                background: var(--sw-primary);

                border-color: var(--sw-primary);

                transform: translateY(-1px);
            }


            /* ================================================================
               CHART AREA
            ================================================================ */

            .chart-container {
                position: relative;

                height: 330px;

                width: 100%;
            }


            /* ================================================================
               PREMIUM FOOTER
            ================================================================ */

            .smartwash-footer {
                margin-top: 32px;

                background:
                    linear-gradient(
                        135deg,
                        #061d45 0%,
                        #082f6b 50%,
                        #0d6efd 100%
                    );

                color: #fff;

                position: relative;

                overflow: hidden;
            }

            .smartwash-footer::before {
                content: "";

                position: absolute;

                width: 280px;
                height: 280px;

                right: -100px;
                top: -150px;

                border-radius: 50%;

                background: rgba(255, 255, 255, 0.05);
            }

            .smartwash-footer::after {
                content: "";

                position: absolute;

                width: 180px;
                height: 180px;

                left: -90px;
                bottom: -100px;

                border-radius: 50%;

                background: rgba(255, 255, 255, 0.04);
            }

            .footer-inner {
                position: relative;

                z-index: 2;

                padding: 26px 28px;

                display: flex;

                align-items: center;

                justify-content: space-between;

                gap: 20px;

                flex-wrap: wrap;
            }

            .footer-brand {
                display: flex;

                align-items: center;

                gap: 12px;
            }

            .footer-logo {
                width: 42px;
                height: 42px;

                border-radius: 12px;

                display: flex;

                align-items: center;
                justify-content: center;

                color: var(--sw-primary);

                background: #fff;

                box-shadow:
                    0 8px 20px rgba(0, 0, 0, 0.15);
            }

            .footer-brand-title {
                font-size: 0.95rem;
                font-weight: 800;

                margin: 0;
            }

            .footer-brand-subtitle {
                margin: 2px 0 0;

                color: rgba(255, 255, 255, 0.65);

                font-size: 0.72rem;
            }

            .footer-copy {
                color: rgba(255, 255, 255, 0.7);

                font-size: 0.76rem;

                margin: 0;
            }

            .footer-links {
                display: flex;

                align-items: center;

                gap: 18px;
            }

            .footer-links a {
                color: rgba(255, 255, 255, 0.75);

                text-decoration: none;

                font-size: 0.76rem;

                font-weight: 600;

                transition: color 0.2s ease;
            }

            .footer-links a:hover {
                color: #fff;
            }


            /* ================================================================
               RESPONSIVE
            ================================================================ */

            @media (max-width: 991.98px) {

                .top-action-bar .btn {
                    flex: 1 1 calc(50% - 10px);
                }

                .chart-container {
                    height: 280px;
                }
            }


            @media (max-width: 767.98px) {

                .smartwash-dashboard {
                    padding-left: 8px;
                    padding-right: 8px;
                }

                .top-action-bar {
                    padding: 10px;
                }

                .top-action-bar .btn {
                    flex: 1 1 100%;
                }

                .stat-value {
                    font-size: 1.45rem;
                }

                .stat-icon {
                    width: 54px;
                    height: 54px;
                }

                .content-card .card-header {
                    padding: 15px;
                }

                .modern-table thead th,
                .modern-table tbody td {
                    padding: 12px;
                }

                .footer-inner {
                    text-align: center;

                    justify-content: center;
                }

                .footer-brand {
                    justify-content: center;

                    width: 100%;
                }

                .footer-copy {
                    width: 100%;
                }

                .footer-links {
                    width: 100%;

                    justify-content: center;
                }
            }
        </style>


        <div class="smartwash-dashboard">

            <div class="container-fluid pt-4">

                {{-- =========================================================
                     TOP ACTIONS
                ========================================================== --}}

                <div class="top-action-bar">

                    <a href="{{ route('pos.index') }}"
                       class="btn btn-primary">

                        <i class="bi bi-plus-circle"></i>

                        Make New Order
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

                        <i class="bi bi-graph-up"></i>

                        Monthly Sales
                    </a>

                </div>


                {{-- =========================================================
                     STATISTICS
                ========================================================== --}}

                <div class="row mb-4">

                    {{-- Today's Sales --}}

                    <div class="col-xl-3 col-md-6 mb-4">

                        <div class="card h-100 modern-card stat-card bg-gradient-primary">

                            <div class="card-body d-flex align-items-center p-4">

                                <div class="stat-icon text-white me-3">

                                    <i class="bi bi-currency-dollar"></i>

                                </div>

                                <div class="position-relative">

                                    <span class="stat-label">
                                        Today's Sales
                                    </span>

                                    <div class="stat-value">
                                        Ksh {{ number_format($todaySales, 2) }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Today's Orders --}}

                    <div class="col-xl-3 col-md-6 mb-4">

                        <div class="card h-100 modern-card stat-card bg-gradient-success">

                            <div class="card-body d-flex align-items-center p-4">

                                <div class="stat-icon text-white me-3">

                                    <i class="bi bi-bag-check"></i>

                                </div>

                                <div class="position-relative">

                                    <span class="stat-label">
                                        Today's Orders
                                    </span>

                                    <div class="stat-value">
                                        {{ $totalOrders }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Pending Orders --}}

                    <div class="col-xl-3 col-md-6 mb-4">

                        <div class="card h-100 modern-card stat-card bg-gradient-warning">

                            <div class="card-body d-flex align-items-center p-4">

                                <div class="stat-icon text-white me-3">

                                    <i class="bi bi-hourglass-split"></i>

                                </div>

                                <div class="position-relative">

                                    <span class="stat-label">
                                        Pending Processing
                                    </span>

                                    <div class="stat-value">
                                        {{ $pendingOrders }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Ready for Pickup --}}

                    <div class="col-xl-3 col-md-6 mb-4">

                        <div class="card h-100 modern-card stat-card bg-gradient-info">

                            <div class="card-body d-flex align-items-center p-4">

                                <div class="stat-icon text-white me-3">

                                    <i class="bi bi-bell"></i>

                                </div>

                                <div class="position-relative">

                                    <span class="stat-label">
                                        Ready for Pickup
                                    </span>

                                    <div class="stat-value">
                                        {{ $readyOrders }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =========================================================
                     CHART + QUICK ACTIONS
                ========================================================== --}}

                <div class="row mb-4">

                    {{-- Sales Chart --}}

                    <div class="col-xl-8 col-lg-7 mb-4 mb-xl-0">

                        <div class="card content-card h-100">

                            <div class="card-header d-flex align-items-center justify-content-between">

                                <h6 class="card-title">

                                    <i class="bi bi-graph-up-arrow me-2"></i>

                                    Earnings Overview

                                </h6>


                                <span class="badge rounded-pill"
                                      style="
                                          background:#eaf3ff;
                                          color:#0d6efd;
                                          padding:7px 11px;
                                          font-weight:700;
                                      ">

                                    Last 7 Days

                                </span>

                            </div>


                            <div class="card-body">

                                <div class="chart-container">

                                    <canvas id="salesChart"></canvas>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Quick Actions --}}

                    <div class="col-xl-4 col-lg-5">

                        <div class="card content-card h-100">

                            <div class="card-header">

                                <h6 class="card-title">

                                    <i class="bi bi-lightning-charge-fill me-2"></i>

                                    Quick Actions

                                </h6>

                            </div>


                            <div class="card-body d-flex flex-column justify-content-center p-4">

                                <a href="{{ route('pos.index') }}"
                                   class="btn btn-action btn-primary mb-3">

                                    <i class="bi bi-plus-circle me-2"></i>

                                    Create New Order

                                </a>


                                <a href="{{ route('orders.index') }}"
                                   class="btn btn-action btn-outline-secondary">

                                    <i class="bi bi-list-ul me-2"></i>

                                    View All Orders

                                </a>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =========================================================
                     RECENT ORDERS
                ========================================================== --}}

                <div class="row">

                    <div class="col-12">

                        <div class="card content-card">

                            <div class="card-header d-flex justify-content-between align-items-center">

                                <h6 class="card-title">

                                    <i class="bi bi-clock-history me-2"></i>

                                    Recent Orders

                                </h6>


                                <a href="{{ route('orders.index') }}"
                                   class="small text-decoration-none fw-bold"
                                   style="color:#0d6efd;">

                                    View All

                                    <i class="bi bi-arrow-right ms-1"></i>

                                </a>

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

                                                    {{-- Invoice --}}

                                                    <td>

                                                        <strong>
                                                            {{ $order->invoice_no }}
                                                        </strong>

                                                    </td>


                                                    {{-- Customer --}}

                                                    <td>

                                                        <div class="fw-semibold">

                                                            {{ $order->customer_name ?? 'Walk-in Customer' }}

                                                        </div>

                                                    </td>


                                                    {{-- Total --}}

                                                    <td>

                                                        <strong style="color:#10233f;">

                                                            Ksh
                                                            {{ number_format($order->total_amount, 2) }}

                                                        </strong>

                                                    </td>


                                                    {{-- Status --}}

                                                    <td>

                                                        @php

                                                            $status = strtolower(
                                                                trim($order->status ?? 'pending')
                                                            );

                                                            /*
                                                             * Status → Visual Class
                                                             *
                                                             * pending    = amber
                                                             * processing = blue
                                                             * ready      = purple
                                                             * delivered  = green
                                                             * cancelled  = red
                                                             */

                                                            $status_class = match ($status) {

                                                                'pending'
                                                                    => 'status-pending',

                                                                'processing'
                                                                    => 'status-processing',

                                                                'ready'
                                                                    => 'status-ready',

                                                                'delivered'
                                                                    => 'status-delivered',

                                                                'cancelled'
                                                                    => 'status-cancelled',

                                                                default
                                                                    => 'status-info',

                                                            };


                                                            $status_icon = match ($status) {

                                                                'pending'
                                                                    => 'bi-hourglass-split',

                                                                'processing'
                                                                    => 'bi-arrow-repeat',

                                                                'ready'
                                                                    => 'bi-check2-circle',

                                                                'delivered'
                                                                    => 'bi-check-circle-fill',

                                                                'cancelled'
                                                                    => 'bi-x-circle-fill',

                                                                default
                                                                    => 'bi-circle-fill',

                                                            };

                                                        @endphp


                                                        <span class="status-badge {{ $status_class }}">

                                                            <i class="bi {{ $status_icon }}"></i>

                                                            {{ ucfirst($status) }}

                                                        </span>

                                                    </td>


                                                    {{-- Date --}}

                                                    <td>

                                                        <span style="color:#718096;">

                                                            {{ $order->created_at->format('M d, Y h:i A') }}

                                                        </span>

                                                    </td>


                                                    {{-- Receipt --}}

                                                    <td>

                                                        <a href="{{ route('pos.receipt', $order->id) }}"
                                                           class="btn btn-sm receipt-btn"
                                                           target="_blank"
                                                           rel="noopener">

                                                            <i class="bi bi-receipt me-1"></i>

                                                            Receipt

                                                        </a>

                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>

                                                    <td colspan="6"
                                                        class="text-center py-5">

                                                        <div style="color:#94a3b8;">

                                                            <i class="bi bi-inbox"
                                                               style="font-size:3rem;"></i>

                                                            <div class="mt-2 fw-semibold">

                                                                No recent orders found.

                                                            </div>

                                                            <small>

                                                                New orders will appear here.

                                                            </small>

                                                        </div>

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


            {{-- =============================================================
                 PREMIUM FOOTER
            ============================================================== --}}

            <footer class="smartwash-footer">

                <div class="container-fluid">

                    <div class="footer-inner">

                        <div class="footer-brand">

                            <div class="footer-logo">

                                <i class="bi bi-droplet-fill"></i>

                            </div>


                            <div>

                                <p class="footer-brand-title">

                                    SmartWash

                                </p>

                                <p class="footer-brand-subtitle">

                                    Laundry Management System

                                </p>

                            </div>

                        </div>


                        <p class="footer-copy">

                            © {{ date('Y') }} SmartWash.

                            All rights reserved.

                        </p>


                        <div class="footer-links">

                            <a href="{{ route('pos.dashboard') }}">

                                Dashboard

                            </a>


                            <a href="{{ route('orders.index') }}">

                                Orders

                            </a>


                            <a href="{{ route('sales.monthly') }}">

                                Reports

                            </a>

                        </div>

                    </div>

                </div>

            </footer>

        </div>

    @endsection


    @push('scripts')

        {{-- ================================================================
             CHART.JS
        ================================================================= --}}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                const canvas = document.getElementById('salesChart');

                if (!canvas) {
                    return;
                }

                const ctx = canvas.getContext('2d');


                /*
                |--------------------------------------------------------------------------
                | PHP → JavaScript Data
                |--------------------------------------------------------------------------
                */

                const labels = {!! json_encode(array_keys($salesData->toArray())) !!};

                const data = {!! json_encode(array_values($salesData->toArray())) !!};


                /*
                |--------------------------------------------------------------------------
                | Chart Gradient
                |--------------------------------------------------------------------------
                */

                const gradient = ctx.createLinearGradient(
                    0,
                    0,
                    0,
                    330
                );

                gradient.addColorStop(
                    0,
                    'rgba(13, 110, 253, 0.22)'
                );

                gradient.addColorStop(
                    1,
                    'rgba(13, 110, 253, 0.01)'
                );


                /*
                |--------------------------------------------------------------------------
                | Sales Chart
                |--------------------------------------------------------------------------
                */

                new Chart(ctx, {

                    type: 'line',

                    data: {

                        labels: labels,

                        datasets: [{

                            label: 'Sales (Ksh)',

                            data: data,

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

                            tension: 0.42,

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

                                        return 'Ksh ' +
                                            Number(value).toLocaleString();

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

                                    font: {

                                        family: "'Segoe UI', sans-serif",

                                        size: 11

                                    }

                                }

                            }

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

                                        return 'Ksh ' +
                                            Number(
                                                context.parsed.y
                                            ).toLocaleString();

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