{{-- resources/views/components/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | LaundryPOS</title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    >

    <style>
        /* ================================================================
           PREMIUM LAUNDRYPOS DESIGN SYSTEM
           ================================================================ */

        :root {
            --primary: #0d6efd;
            --primary-dark: #0a58ca;
            --primary-deeper: #084298;
            --primary-light: #eaf3ff;
            --primary-soft: #f4f8ff;

            --sidebar-bg: #071a33;
            --sidebar-bg-2: #0b2445;
            --sidebar-hover: rgba(255, 255, 255, 0.075);
            --sidebar-active: #0d6efd;

            --white: #ffffff;
            --body-bg: #f4f7fb;
            --surface: #ffffff;

            --text-dark: #14213d;
            --text-muted: #718096;
            --border: #e5eaf1;

            --success: #16a34a;
            --warning: #f59e0b;
            --danger: #dc3545;

            --sidebar-width: 280px;
            --sidebar-collapsed-width: 84px;

            --header-height: 76px;

            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 18px;

            --shadow-sm: 0 4px 16px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 10px 30px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 20px 50px rgba(15, 23, 42, 0.12);
        }

        /* ================================================================
           GLOBAL
           ================================================================ */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            padding: 0;
            background:
                linear-gradient(
                    180deg,
                    #f7faff 0%,
                    #f4f7fb 45%,
                    #f1f5f9 100%
                );
            color: var(--text-dark);
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            font-size: 14px;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        button,
        a,
        input,
        select,
        textarea {
            outline: none !important;
        }

        ::selection {
            background: rgba(13, 110, 253, 0.18);
            color: var(--primary-deeper);
        }

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #b8c5d6;
            border-radius: 20px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #91a3bb;
        }

        /* ================================================================
           SIDEBAR
           ================================================================ */

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;

            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;

            background:
                radial-gradient(
                    circle at top right,
                    rgba(13, 110, 253, 0.22),
                    transparent 34%
                ),
                linear-gradient(
                    180deg,
                    var(--sidebar-bg-2) 0%,
                    var(--sidebar-bg) 100%
                );

            color: #fff;

            z-index: 1050;

            display: flex;
            flex-direction: column;

            border-right: 1px solid rgba(255, 255, 255, 0.06);

            box-shadow:
                8px 0 35px rgba(4, 18, 38, 0.12);

            transition:
                transform 0.3s ease,
                width 0.3s ease;
        }

        /* ================================================================
           BRAND
           ================================================================ */

        .sidebar-brand {
            height: 88px;
            padding: 20px 22px;

            display: flex;
            align-items: center;
            gap: 13px;

            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .brand-logo {
            width: 45px;
            height: 45px;

            flex: 0 0 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    #0d6efd,
                    #3d8bfd
                );

            box-shadow:
                0 8px 22px rgba(13, 110, 253, 0.32);

            font-size: 1.35rem;
        }

        .brand-content {
            min-width: 0;
        }

        .brand-name {
            color: #fff;
            font-size: 1.12rem;
            font-weight: 800;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.52);
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.9px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* ================================================================
           SIDEBAR USER
           ================================================================ */

        .sidebar-user {
            margin: 18px 16px 10px;

            padding: 13px;

            display: flex;
            align-items: center;
            gap: 11px;

            background: rgba(255, 255, 255, 0.055);

            border: 1px solid rgba(255, 255, 255, 0.07);

            border-radius: 14px;
        }

        .sidebar-user-avatar {
            width: 40px;
            height: 40px;

            flex: 0 0 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #ffffff,
                #dbeafe
            );

            color: var(--primary);

            font-weight: 800;
            font-size: 0.9rem;
        }

        .sidebar-user-info {
            min-width: 0;
        }

        .sidebar-user-name {
            color: #fff;
            font-weight: 700;
            font-size: 0.82rem;

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            color: rgba(255, 255, 255, 0.48);
            font-size: 0.69rem;
            margin-top: 2px;
        }

        .online-indicator {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            display: inline-block;
            margin-right: 4px;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.12);
        }

        /* ================================================================
           NAVIGATION
           ================================================================ */

        .sidebar-nav {
            flex: 1;

            overflow-y: auto;
            overflow-x: hidden;

            padding: 8px 13px 20px;
        }

        .nav-section {
            margin-top: 18px;
            margin-bottom: 8px;

            padding: 0 12px;

            color: rgba(255, 255, 255, 0.34);

            font-size: 0.64rem;
            font-weight: 800;

            letter-spacing: 1.25px;
            text-transform: uppercase;
        }

        .sidebar-menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar-menu-item {
            margin-bottom: 4px;
        }

        .sidebar-link {
            width: 100%;

            min-height: 48px;

            padding: 11px 13px;

            display: flex;
            align-items: center;
            gap: 12px;

            position: relative;

            color: rgba(255, 255, 255, 0.67);

            border-radius: 12px;

            font-size: 0.84rem;
            font-weight: 600;

            transition:
                background 0.2s ease,
                color 0.2s ease,
                transform 0.2s ease;
        }

        .sidebar-link i {
            width: 21px;

            flex: 0 0 21px;

            text-align: center;

            font-size: 1.08rem;

            color: rgba(255, 255, 255, 0.54);

            transition: color 0.2s ease;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
            transform: translateX(2px);
        }

        .sidebar-link:hover i {
            color: #fff;
        }

        .sidebar-link.active {
            color: #fff;

            background:
                linear-gradient(
                    135deg,
                    rgba(13, 110, 253, 0.98),
                    rgba(10, 88, 202, 0.96)
                );

            box-shadow:
                0 8px 20px rgba(13, 110, 253, 0.22);
        }

        .sidebar-link.active::before {
            content: "";

            position: absolute;

            left: -13px;
            top: 8px;
            bottom: 8px;

            width: 3px;

            border-radius: 0 4px 4px 0;

            background: #fff;
        }

        .sidebar-link.active i {
            color: #fff;
        }

        .sidebar-link-text {
            flex: 1;
            min-width: 0;
        }

        .sidebar-badge {
            min-width: 23px;
            height: 23px;

            padding: 0 7px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 20px;

            background: #ef4444;
            color: #fff;

            font-size: 0.66rem;
            font-weight: 800;

            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
        }

        /* ================================================================
           SIDEBAR FOOTER
           ================================================================ */

        .sidebar-footer {
            padding: 14px;

            border-top: 1px solid rgba(255, 255, 255, 0.07);

            background: rgba(0, 0, 0, 0.08);
        }

        .sidebar-footer-card {
            padding: 10px;

            border-radius: 13px;

            background: rgba(255, 255, 255, 0.045);

            border: 1px solid rgba(255, 255, 255, 0.055);
        }

        .logout-button {
            width: 100%;

            min-height: 44px;

            border: 0;

            padding: 10px 12px;

            display: flex;
            align-items: center;
            gap: 11px;

            color: rgba(255, 255, 255, 0.66);

            background: transparent;

            border-radius: 10px;

            font-size: 0.83rem;
            font-weight: 600;

            cursor: pointer;

            transition: all 0.2s ease;
        }

        .logout-button i {
            font-size: 1.05rem;
        }

        .logout-button:hover {
            color: #fff;
            background: rgba(220, 53, 69, 0.18);
        }

        /* ================================================================
           MAIN CONTENT
           ================================================================ */

        .main-content {
            margin-left: var(--sidebar-width);

            min-height: 100vh;

            padding: 0;

            transition: margin-left 0.3s ease;
        }

        /* ================================================================
           DESKTOP TOP HEADER
           ================================================================ */

        .desktop-header {
            height: var(--header-height);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 30px;

            background: rgba(255, 255, 255, 0.92);

            border-bottom: 1px solid var(--border);

            backdrop-filter: blur(16px);

            position: sticky;
            top: 0;

            z-index: 900;
        }

        .header-page-info {
            min-width: 0;
        }

        .header-eyebrow {
            color: var(--primary);
            font-size: 0.64rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            margin-bottom: 2px;
        }

        .header-title {
            margin: 0;

            color: var(--text-dark);

            font-size: 1.22rem;
            font-weight: 800;

            letter-spacing: -0.4px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-welcome {
            padding: 9px 13px;

            display: flex;
            align-items: center;
            gap: 9px;

            background: var(--primary-soft);

            border: 1px solid #dbeafe;

            border-radius: 11px;

            color: #38506f;

            font-size: 0.78rem;
            font-weight: 600;
        }

        .header-welcome-avatar {
            width: 30px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: var(--primary);
            color: #fff;

            font-size: 0.72rem;
            font-weight: 800;
        }

        /* ================================================================
           PAGE WRAPPER
           ================================================================ */

        .page-wrapper {
            padding: 28px 30px 34px;
        }

        /* ================================================================
           CONTENT CARD
           ================================================================ */

        .main-content > .content-container {
            width: 100%;
        }

        .main-slot-card {
            background: transparent;
        }

        /* ================================================================
           MOBILE BAR
           ================================================================ */

        .mobile-bar {
            display: none;

            min-height: 66px;

            align-items: center;
            justify-content: space-between;

            padding: 10px 15px;

            background:
                linear-gradient(
                    135deg,
                    #071a33,
                    #0b3970
                );

            color: #fff;

            position: sticky;
            top: 0;

            z-index: 1100;

            box-shadow:
                0 8px 25px rgba(4, 18, 38, 0.18);
        }

        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mobile-brand-logo {
            width: 37px;
            height: 37px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #0d6efd;
            border-radius: 10px;

            font-size: 1rem;
        }

        .mobile-brand-name {
            font-weight: 800;
            font-size: 0.98rem;
        }

        .mobile-brand-subtitle {
            font-size: 0.6rem;
            color: rgba(255, 255, 255, 0.55);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .mobile-menu-button {
            width: 42px;
            height: 42px;

            border: 1px solid rgba(255, 255, 255, 0.12);

            background: rgba(255, 255, 255, 0.07);

            color: #fff;

            border-radius: 11px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 1.25rem;

            cursor: pointer;
        }

        .mobile-menu-button:hover {
            background: rgba(255, 255, 255, 0.13);
        }

        /* ================================================================
           SIDEBAR BACKDROP
           ================================================================ */

        .sidebar-backdrop {
            display: none;

            position: fixed;
            inset: 0;

            background: rgba(2, 12, 27, 0.58);

            backdrop-filter: blur(3px);

            z-index: 1040;
        }

        .sidebar-backdrop.show {
            display: block;
        }

        /* ================================================================
           GLOBAL BUTTONS
           ================================================================ */

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* ================================================================
           PREMIUM FOOTER
           ================================================================ */

        .app-footer {
            margin-top: 10px;

            background:
                linear-gradient(
                    135deg,
                    #071a33 0%,
                    #0a2850 50%,
                    #0d3c78 100%
                );

            color: #fff;

            border-radius: 18px;

            overflow: hidden;

            position: relative;

            box-shadow:
                0 15px 40px rgba(7, 26, 51, 0.14);
        }

        .app-footer::before {
            content: "";

            position: absolute;

            width: 260px;
            height: 260px;

            right: -100px;
            top: -130px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.045);
        }

        .app-footer::after {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            left: -80px;
            bottom: -110px;

            border-radius: 50%;

            background: rgba(13, 110, 253, 0.12);
        }

        .footer-inner {
            position: relative;
            z-index: 1;

            padding: 22px 24px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .footer-brand-icon {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: rgba(255, 255, 255, 0.1);

            border: 1px solid rgba(255, 255, 255, 0.1);

            font-size: 1rem;
        }

        .footer-brand strong {
            font-size: 0.85rem;
        }

        .footer-brand small {
            display: block;

            margin-top: 2px;

            color: rgba(255, 255, 255, 0.5);

            font-size: 0.68rem;
        }

        .footer-right {
            color: rgba(255, 255, 255, 0.48);

            font-size: 0.7rem;

            text-align: right;
        }

        .footer-right strong {
            color: rgba(255, 255, 255, 0.76);
        }

        /* ================================================================
           RESPONSIVE
           ================================================================ */

        @media (max-width: 991.98px) {
            :root {
                --sidebar-width: 270px;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .mobile-bar {
                display: flex;
            }

            .desktop-header {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .page-wrapper {
                padding: 20px 16px 25px;
            }
        }

        @media (max-width: 575.98px) {
            .page-wrapper {
                padding: 16px 12px 20px;
            }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-right {
                text-align: left;
            }

            .sidebar {
                width: 290px;
            }
        }

        /* ================================================================
           OPTIONAL PREMIUM UTILITY CLASSES
           ================================================================ */

        .text-primary {
            color: var(--primary) !important;
        }

        .bg-primary-soft {
            background: var(--primary-soft) !important;
        }

        .border-primary-soft {
            border-color: #dbeafe !important;
        }

        .premium-shadow {
            box-shadow: var(--shadow-md);
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- ================================================================
         MOBILE HEADER
         ================================================================ --}}
    <header class="mobile-bar">

        <div class="mobile-brand">

            <div class="mobile-brand-logo">
                <i class="bi bi-droplet-half"></i>
            </div>

            <div>
                <div class="mobile-brand-name">
                    LaundryPOS
                </div>

                <div class="mobile-brand-subtitle">
                    Laundry Management
                </div>
            </div>

        </div>

        <button
            type="button"
            id="sidebarToggle"
            class="mobile-menu-button"
            aria-label="Open navigation menu"
            aria-expanded="false"
        >
            <i class="bi bi-list"></i>
        </button>

    </header>


    {{-- ================================================================
         MOBILE SIDEBAR BACKDROP
         ================================================================ --}}
    <div
        class="sidebar-backdrop"
        id="sidebarBackdrop"
    ></div>


    {{-- ================================================================
         SIDEBAR
         ================================================================ --}}
    <aside
        class="sidebar"
        id="sidebar"
    >

        {{-- BRAND --}}
        <div class="sidebar-brand">

            <div class="brand-logo">
                <i class="bi bi-droplet-half"></i>
            </div>

            <div class="brand-content">
                <div class="brand-name">
                    LaundryPOS
                </div>

                <div class="brand-subtitle">
                    Smart Laundry Management
                </div>
            </div>

        </div>


        {{-- USER --}}
        @php
            $currentUser = auth()->user();

            $userName = $currentUser?->name ?? 'Administrator';

            $userInitials = collect(
                preg_split('/\s+/', trim($userName))
            )
                ->filter()
                ->take(2)
                ->map(fn ($name) => strtoupper(substr($name, 0, 1)))
                ->implode('');

            $userInitials = $userInitials ?: 'AD';
        @endphp

        <div class="sidebar-user">

            <div class="sidebar-user-avatar">
                {{ $userInitials }}
            </div>

            <div class="sidebar-user-info">

                <div class="sidebar-user-name">
                    {{ $userName }}
                </div>

                <div class="sidebar-user-role">
                    <span class="online-indicator"></span>
                    Online Administrator
                </div>

            </div>

        </div>


        {{-- ============================================================
             NAVIGATION
             ============================================================ --}}
        <nav class="sidebar-nav">

            {{-- MAIN --}}
            <div class="nav-section">
                Main
            </div>

            <ul class="sidebar-menu">

                {{-- Dashboard --}}
                <li class="sidebar-menu-item">

                    <a
                        href="{{ route('pos.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('pos.dashboard') ? 'active' : '' }}"
                    >

                        <i class="bi bi-grid-1x2-fill"></i>

                        <span class="sidebar-link-text">
                            Dashboard
                        </span>

                    </a>

                </li>


                {{-- POS --}}
                <li class="sidebar-menu-item">

                    <a
                        href="{{ route('pos.index') }}"
                        class="sidebar-link {{ request()->routeIs('pos.index') ? 'active' : '' }}"
                    >

                        <i class="bi bi-cart3"></i>

                        <span class="sidebar-link-text">
                            POS Terminal
                        </span>

                    </a>

                </li>

            </ul>


            {{-- ORDERS --}}
            <div class="nav-section">
                Order Management
            </div>

            <ul class="sidebar-menu">

                {{-- Online Orders --}}
                <li class="sidebar-menu-item">

                    <a
                        href="{{ route('online-orders.index') }}"
                        class="sidebar-link {{ request()->routeIs('online-orders.*') ? 'active' : '' }}"
                    >

                        <i class="bi bi-bag-check-fill"></i>

                        <span class="sidebar-link-text">
                            Online Orders
                        </span>

                        @if (($pendingOnlineOrders ?? 0) > 0)

                            <span class="sidebar-badge">
                                {{ $pendingOnlineOrders }}
                            </span>

                        @endif

                    </a>

                </li>


                {{-- Walk-In Orders --}}
                <li class="sidebar-menu-item">

                    <a
                        href="{{ route('orders.index') }}"
                        class="sidebar-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                    >

                        <i class="bi bi-receipt-cutoff"></i>

                        <span class="sidebar-link-text">
                            Walk-In Orders
                        </span>

                    </a>

                </li>

            </ul>


            {{-- MANAGEMENT --}}
            <div class="nav-section">
                Management
            </div>

            <ul class="sidebar-menu">

                {{-- Services --}}
                <li class="sidebar-menu-item">

                    <a
                        href="{{ route('services.index') }}"
                        class="sidebar-link {{ request()->routeIs('services.*') ? 'active' : '' }}"
                    >

                        <i class="bi bi-box-seam-fill"></i>

                        <span class="sidebar-link-text">
                            Laundry Services
                        </span>

                    </a>

                </li>

            </ul>


            {{-- REPORTING --}}
            <div class="nav-section">
                Business Intelligence
            </div>

            <ul class="sidebar-menu">

                {{-- Reports --}}
                <li class="sidebar-menu-item">

                    <a
                        href="{{ route('sales.monthly') }}"
                        class="sidebar-link {{ request()->routeIs('sales.*') ? 'active' : '' }}"
                    >

                        <i class="bi bi-bar-chart-fill"></i>

                        <span class="sidebar-link-text">
                            Sales Reports
                        </span>

                    </a>

                </li>

            </ul>

        </nav>


        {{-- ============================================================
             SIDEBAR FOOTER
             ============================================================ --}}
        <div class="sidebar-footer">

            <div class="sidebar-footer-card">

                <form
                    id="logout-form"
                    class="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-button"
                    >

                        <i class="bi bi-box-arrow-left"></i>

                        <span>
                            Sign Out
                        </span>

                    </button>

                </form>

            </div>

        </div>

    </aside>


    {{-- ================================================================
         MAIN CONTENT
         ================================================================ --}}
    <main class="main-content">

        {{-- DESKTOP HEADER --}}
        <header class="desktop-header">

            <div class="header-page-info">

                <div class="header-eyebrow">
                    LaundryPOS Management System
                </div>

                <h1 class="header-title">
                    @yield('title', 'Dashboard')
                </h1>

            </div>


            <div class="header-right">

                <div class="header-welcome">

                    <div class="header-welcome-avatar">
                        {{ $userInitials }}
                    </div>

                    <span>
                        Welcome,
                        <strong>
                            {{ $userName }}
                        </strong>
                    </span>

                </div>

            </div>

        </header>


        {{-- PAGE CONTENT --}}
        <div class="page-wrapper">

            <div class="content-container">

                {{-- ====================================================
                     SUPPORTS <x-layout> SLOT
                     AND @section('content')
                     ==================================================== --}}

                {{ $slot ?? '' }}

                @yield('content')

            </div>


            {{-- ========================================================
                 PREMIUM FOOTER
                 ======================================================== --}}
            <footer class="app-footer mt-4">

                <div class="footer-inner">

                    <div class="footer-brand">

                        <div class="footer-brand-icon">
                            <i class="bi bi-droplet-half"></i>
                        </div>

                        <div>

                            <strong>
                                LaundryPOS
                            </strong>

                            <small>
                                Smart Laundry Management System
                            </small>

                        </div>

                    </div>


                    <div class="footer-right">

                        <div>
                            © {{ date('Y') }}
                            <strong>LaundryPOS</strong>.
                            All rights reserved.
                        </div>

                        <div class="mt-1">
                            Secure • Reliable • Efficient
                        </div>

                    </div>

                </div>

            </footer>

        </div>

    </main>


    {{-- ================================================================
         JAVASCRIPT
         ================================================================ --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')


    <script>

        /* ================================================================
           CSRF
           ================================================================ */

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');

        if (window.jQuery && csrfToken) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

        }


        /* ================================================================
           MOBILE SIDEBAR
           ================================================================ */

        (function () {

            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggleButton = document.getElementById('sidebarToggle');

            if (!sidebar || !backdrop || !toggleButton) {
                return;
            }

            function openSidebar() {

                sidebar.classList.add('open');
                backdrop.classList.add('show');

                toggleButton.setAttribute(
                    'aria-expanded',
                    'true'
                );

                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {

                sidebar.classList.remove('open');
                backdrop.classList.remove('show');

                toggleButton.setAttribute(
                    'aria-expanded',
                    'false'
                );

                document.body.style.overflow = '';
            }

            toggleButton.addEventListener(
                'click',
                function () {

                    if (sidebar.classList.contains('open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }

                }
            );

            backdrop.addEventListener(
                'click',
                closeSidebar
            );


            /* Close sidebar after clicking navigation on mobile */

            sidebar
                .querySelectorAll('.sidebar-link')
                .forEach(function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            if (window.innerWidth <= 991) {
                                closeSidebar();
                            }

                        }
                    );

                });


            /* Close sidebar with ESC */

            document.addEventListener(
                'keydown',
                function (event) {

                    if (
                        event.key === 'Escape' &&
                        sidebar.classList.contains('open')
                    ) {

                        closeSidebar();

                    }

                }
            );


            /* Reset mobile state when resizing */

            window.addEventListener(
                'resize',
                function () {

                    if (window.innerWidth > 991) {

                        closeSidebar();

                    }

                }
            );

        })();


        /* ================================================================
           KEEP SESSION ALIVE
           ================================================================ */

        setInterval(
            function () {

                fetch(
                    '{{ route('keep-alive') }}',
                    {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                )
                .then(function (response) {

                    /*
                     * Laravel may redirect to login when
                     * the authenticated session has expired.
                     */

                    if (response.redirected) {

                        window.location.href = response.url;

                        return;

                    }

                    if (response.status === 401) {

                        window.location.href =
                            '{{ route('login') }}';

                    }

                })
                .catch(function () {

                    /*
                     * Ignore temporary network failures.
                     * The next keep-alive attempt will retry.
                     */

                });

            },
            600000
        );


        /* ================================================================
           PREVENT MULTIPLE LOGOUT SUBMISSIONS
           ================================================================ */

        const logoutForm =
            document.getElementById('logout-form');

        if (logoutForm) {

            logoutForm.addEventListener(
                'submit',
                function () {

                    const button =
                        logoutForm.querySelector('button');

                    if (!button) {
                        return;
                    }

                    button.disabled = true;

                    button.innerHTML = `
                        <span
                            class="spinner-border spinner-border-sm"
                            role="status"
                            aria-hidden="true">
                        </span>

                        <span>
                            Signing out...
                        </span>
                    `;

                }
            );

        }

    </script>

</body>

</html>