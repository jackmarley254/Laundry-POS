{{-- resources/views/components/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | LaundryPOS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root { --sidebar-w: 250px; }

        body { background-color: #f8f9fa; }

        /* ---------- Sidebar ---------- */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            position: fixed;
            inset: 0 auto 0 0;
            background-color: #343a40;
            padding-top: 20px;
            z-index: 1040;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        .sidebar .logo {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .sidebar-nav { flex: 1; }

        .sidebar a,
        .sidebar .logout-form button {
            display: block;
            width: 100%;
            color: #adb5bd;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 1.1em;
            background: none;
            border: 0;
            text-align: left;
        }

        .sidebar i { margin-right: 10px; }

        .sidebar a:hover { background-color: #495057; color: #fff; }
        .sidebar a.active { background-color: #0d6efd; color: #fff; }

        .sidebar-bottom { border-top: 1px solid #495057; padding-top: 10px; }
        .sidebar .logout-form button { cursor: pointer; }
        .sidebar .logout-form button:hover { background-color: #dc3545; color: #fff; }

        /* ---------- Main area ---------- */
        .main-content { margin-left: var(--sidebar-w); padding: 20px; }

        .mobile-bar, .sidebar-backdrop { display: none; }

        /* ---------- Mobile ---------- */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }

            .main-content { margin-left: 0; padding: 12px; }

            .mobile-bar {
                display: flex;
                align-items: center;
                gap: 12px;
                background: #343a40;
                color: #fff;
                padding: 10px 16px;
                position: sticky;
                top: 0;
                z-index: 1030;
            }

            .mobile-bar button { background: none; border: 0; color: #fff; font-size: 1.6rem; line-height: 1; }

            .sidebar-backdrop.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .5);
                z-index: 1035;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- MOBILE TOP BAR -->
    <header class="mobile-bar">
        <button type="button" id="sidebarToggle" aria-label="Open menu"><i class="bi bi-list"></i></button>
        <span class="fw-bold"><i class="bi bi-droplet-half"></i> LaundryPOS</span>
    </header>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="logo">
            <i class="bi bi-droplet-half"></i> LaundryPOS
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('pos.dashboard') }}"
               class="{{ request()->routeIs('pos.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="{{ route('pos.index') }}"
               class="{{ request()->routeIs('pos.index') ? 'active' : '' }}">
                <i class="bi bi-cart-plus"></i> POS Terminal
            </a>

            <a href="{{ route('online-orders.index') }}"
               class="{{ request()->routeIs('online-orders.*') ? 'active' : '' }}">
                <i class="bi bi-bag-check"></i> Online Orders
                @if (($pendingOnlineOrders ?? 0) > 0)
                    <span class="badge bg-danger float-end">{{ $pendingOnlineOrders }}</span>
                @endif
            </a>

            <a href="{{ route('orders.index') }}"
               class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i> Walk-In Orders
            </a>

            <a href="{{ route('services.index') }}"
               class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Services
            </a>

            <a href="{{ route('sales.monthly') }}"
               class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i> Reports
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form id="logout-form" class="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="bi bi-box-arrow-left"></i> Logout</button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">@yield('title')</h3>
            <span class="text-muted">Welcome, {{ auth()->user()->name ?? 'Admin' }}</span>
        </div>

        <div class="card shadow-sm p-4">
            {{-- Supports both <x-layout> slots and @section('content') --}}
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script>
        // Send the CSRF token with every jQuery AJAX request
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });

        // Mobile sidebar toggle
        (function () {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggle = () => {
                sidebar.classList.toggle('open');
                backdrop.classList.toggle('show');
            };
            document.getElementById('sidebarToggle').addEventListener('click', toggle);
            backdrop.addEventListener('click', toggle);
        })();

        // Keep the session alive; if it has already expired, go to login
        setInterval(function () {
            fetch('{{ route('keep-alive') }}', { credentials: 'same-origin' })
                .then(function (r) { if (r.redirected) window.location.href = r.url; })
                .catch(function () {});
        }, 600000); // every 10 minutes
    </script>
</body>

</html>