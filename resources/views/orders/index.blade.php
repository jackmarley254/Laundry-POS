<x-layout>

    @section('title', 'Order Management')

    @section('content')

        <style>
            :root {
                --om-navy: #071a33;
                --om-navy-2: #0b2a4a;
                --om-blue: #0d6efd;
                --om-blue-dark: #0b5ed7;
                --om-blue-soft: #eaf3ff;
                --om-surface: #f5f8fc;
                --om-line: #e6edf5;
                --om-text: #122033;
                --om-muted: #6b7a90;
                --om-white: #ffffff;
                --om-success: #16845b;
                --om-success-soft: #eafaf3;
                --om-warning: #b7791f;
                --om-warning-soft: #fff8e8;
                --om-danger: #c53030;
                --om-danger-soft: #fff1f1;
                --om-shadow: 0 12px 35px rgba(7, 26, 51, .07);
            }

            .order-management-page {
                color: var(--om-text);
                padding: 4px 0 30px;
            }

            /* =========================================================
               HERO
            ========================================================= */

            .om-hero {
                position: relative;
                overflow: hidden;
                border-radius: 22px;
                padding: 30px 32px;
                margin-bottom: 24px;
                color: #fff;
                background:
                    radial-gradient(
                        circle at 88% 15%,
                        rgba(255, 255, 255, .16),
                        transparent 28%
                    ),
                    linear-gradient(
                        135deg,
                        var(--om-navy) 0%,
                        var(--om-navy-2) 52%,
                        #0d6efd 140%
                    );
                box-shadow: 0 18px 40px rgba(7, 26, 51, .18);
            }

            .om-hero::before {
                content: "";
                position: absolute;
                width: 280px;
                height: 280px;
                right: -120px;
                top: -150px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .06);
            }

            .om-hero::after {
                content: "";
                position: absolute;
                width: 180px;
                height: 180px;
                right: 120px;
                bottom: -140px;
                border-radius: 50%;
                background: rgba(13, 110, 253, .25);
            }

            .om-hero-content {
                position: relative;
                z-index: 2;
            }

            .om-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 7px 11px;
                border-radius: 999px;
                background: rgba(255, 255, 255, .10);
                border: 1px solid rgba(255, 255, 255, .15);
                color: rgba(255, 255, 255, .88);
                font-size: .68rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .09em;
                margin-bottom: 12px;
            }

            .om-hero h1 {
                margin: 0;
                font-size: clamp(1.65rem, 3vw, 2.15rem);
                font-weight: 800;
                letter-spacing: -.035em;
            }

            .om-hero p {
                margin: 8px 0 0;
                max-width: 650px;
                color: rgba(255, 255, 255, .72);
                font-size: .88rem;
                line-height: 1.6;
            }

            .om-hero-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 18px;
            }

            .om-meta-chip {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 7px 11px;
                border-radius: 9px;
                background: rgba(255, 255, 255, .08);
                border: 1px solid rgba(255, 255, 255, .13);
                font-size: .72rem;
                color: rgba(255, 255, 255, .82);
            }

            .om-hero-stat {
                min-width: 190px;
                padding: 20px;
                border-radius: 16px;
                background: rgba(255, 255, 255, .09);
                border: 1px solid rgba(255, 255, 255, .15);
                backdrop-filter: blur(12px);
            }

            .om-hero-stat-label {
                color: rgba(255, 255, 255, .62);
                font-size: .68rem;
                text-transform: uppercase;
                letter-spacing: .07em;
                font-weight: 700;
            }

            .om-hero-stat-value {
                display: block;
                margin-top: 5px;
                font-size: 1.8rem;
                font-weight: 800;
                letter-spacing: -.04em;
            }

            .om-hero-stat-note {
                color: rgba(255, 255, 255, .6);
                font-size: .7rem;
            }

            /* =========================================================
               FILTER PANEL
            ========================================================= */

            .om-filter-card {
                background: var(--om-white);
                border: 1px solid var(--om-line);
                border-radius: 18px;
                box-shadow: var(--om-shadow);
                overflow: hidden;
                margin-bottom: 24px;
            }

            .om-filter-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
                padding: 17px 20px;
                border-bottom: 1px solid var(--om-line);
            }

            .om-section-heading {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .om-section-icon {
                width: 40px;
                height: 40px;
                border-radius: 11px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: var(--om-blue-soft);
                color: var(--om-blue);
                flex-shrink: 0;
            }

            .om-section-heading h6 {
                margin: 0;
                color: var(--om-text);
                font-size: .9rem;
                font-weight: 800;
            }

            .om-section-heading p {
                margin: 2px 0 0;
                color: var(--om-muted);
                font-size: .72rem;
            }

            .om-filter-body {
                padding: 20px;
            }

            .om-label {
                display: block;
                margin-bottom: 7px;
                color: var(--om-muted);
                font-size: .66rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .06em;
            }

            .om-form-control {
                min-height: 43px;
                border: 1px solid var(--om-line);
                border-radius: 10px;
                color: var(--om-text);
                background: #fff;
                font-size: .82rem;
                box-shadow: none;
                transition: .18s ease;
            }

            .om-form-control:focus {
                border-color: rgba(13, 110, 253, .65);
                box-shadow: 0 0 0 4px rgba(13, 110, 253, .10);
            }

            .om-form-control.filter-active {
                border-color: rgba(13, 110, 253, .65);
                background: #f8fbff;
            }

            .om-filter-actions {
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
                height: 100%;
            }

            .om-btn-primary {
                min-height: 43px;
                border: 0;
                border-radius: 10px;
                padding: 0 17px;
                background: linear-gradient(135deg, var(--om-blue), var(--om-blue-dark));
                color: #fff;
                font-size: .8rem;
                font-weight: 700;
                box-shadow: 0 8px 18px rgba(13, 110, 253, .20);
                transition: .18s ease;
            }

            .om-btn-primary:hover {
                color: #fff;
                transform: translateY(-1px);
                box-shadow: 0 11px 23px rgba(13, 110, 253, .27);
            }

            .om-btn-light {
                min-height: 43px;
                border: 1px solid var(--om-line);
                border-radius: 10px;
                padding: 0 15px;
                background: #fff;
                color: var(--om-text);
                font-size: .8rem;
                font-weight: 700;
                transition: .18s ease;
            }

            .om-btn-light:hover {
                border-color: #cbd8e8;
                background: #f8fbff;
                color: var(--om-blue);
            }

            .om-btn-export {
                min-height: 43px;
                border: 1px solid rgba(13, 110, 253, .25);
                border-radius: 10px;
                padding: 0 15px;
                background: var(--om-blue-soft);
                color: var(--om-blue-dark);
                font-size: .8rem;
                font-weight: 700;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 7px;
                transition: .18s ease;
            }

            .om-btn-export:hover {
                background: var(--om-blue);
                border-color: var(--om-blue);
                color: #fff;
            }

            /* =========================================================
               STAT CARDS
            ========================================================= */

            .om-stat-card {
                position: relative;
                overflow: hidden;
                height: 100%;
                min-height: 128px;
                padding: 20px;
                background: #fff;
                border: 1px solid var(--om-line);
                border-radius: 17px;
                box-shadow: var(--om-shadow);
                transition: .2s ease;
            }

            .om-stat-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 18px 38px rgba(7, 26, 51, .10);
            }

            .om-stat-card::after {
                content: "";
                position: absolute;
                width: 110px;
                height: 110px;
                right: -55px;
                top: -55px;
                border-radius: 50%;
                background: var(--om-blue-soft);
            }

            .om-stat-icon {
                position: relative;
                z-index: 2;
                width: 43px;
                height: 43px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: var(--om-blue-soft);
                color: var(--om-blue);
                font-size: 1rem;
            }

            .om-stat-label {
                margin-top: 15px;
                color: var(--om-muted);
                font-size: .67rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .06em;
            }

            .om-stat-value {
                margin-top: 3px;
                color: var(--om-text);
                font-size: 1.35rem;
                font-weight: 800;
                letter-spacing: -.03em;
            }

            .om-stat-caption {
                margin-top: 2px;
                color: #94a3b8;
                font-size: .68rem;
            }

            .om-stat-card.dark {
                background: linear-gradient(135deg, var(--om-navy), var(--om-navy-2));
                border-color: transparent;
            }

            .om-stat-card.dark .om-stat-icon {
                background: rgba(255, 255, 255, .11);
                color: #fff;
            }

            .om-stat-card.dark .om-stat-label,
            .om-stat-card.dark .om-stat-caption {
                color: rgba(255, 255, 255, .62);
            }

            .om-stat-card.dark .om-stat-value {
                color: #fff;
            }

            .om-stat-card.blue {
                background: linear-gradient(135deg, #0d6efd, #0956c7);
                border-color: transparent;
            }

            .om-stat-card.blue .om-stat-icon {
                background: rgba(255, 255, 255, .13);
                color: #fff;
            }

            .om-stat-card.blue .om-stat-label,
            .om-stat-card.blue .om-stat-caption {
                color: rgba(255, 255, 255, .67);
            }

            .om-stat-card.blue .om-stat-value {
                color: #fff;
            }

            /* =========================================================
               TABLE CARD
            ========================================================= */

            .om-table-card {
                background: #fff;
                border: 1px solid var(--om-line);
                border-radius: 18px;
                overflow: hidden;
                box-shadow: var(--om-shadow);
            }

            .om-table-header {
                padding: 18px 20px;
                border-bottom: 1px solid var(--om-line);
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 15px;
            }

            .om-table-title {
                display: flex;
                align-items: center;
                gap: 11px;
            }

            .om-table-title h5 {
                margin: 0;
                color: var(--om-text);
                font-size: .95rem;
                font-weight: 800;
            }

            .om-table-title p {
                margin: 3px 0 0;
                color: var(--om-muted);
                font-size: .7rem;
            }

            .om-record-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 10px;
                border-radius: 999px;
                background: var(--om-blue-soft);
                border: 1px solid #d6e7ff;
                color: var(--om-blue-dark);
                font-size: .7rem;
                font-weight: 800;
                white-space: nowrap;
            }

            .om-table-wrap {
                overflow-x: auto;
            }

            .om-table {
                min-width: 920px;
                margin: 0;
            }

            .om-table thead th {
                padding: 13px 16px;
                background: #f8fbff;
                border-bottom: 1px solid var(--om-line);
                color: var(--om-muted);
                font-size: .65rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .07em;
                white-space: nowrap;
            }

            .om-table tbody td {
                padding: 15px 16px;
                vertical-align: middle;
                border-bottom: 1px solid #edf2f7;
                color: var(--om-text);
                font-size: .79rem;
            }

            .om-table tbody tr {
                transition: .15s ease;
            }

            .om-table tbody tr:hover {
                background: #f9fbfe;
            }

            .om-table tbody tr:last-child td {
                border-bottom: 0;
            }

            .invoice-number {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                color: var(--om-blue-dark);
                font-weight: 800;
                font-size: .79rem;
            }

            .invoice-icon {
                width: 30px;
                height: 30px;
                border-radius: 8px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: var(--om-blue-soft);
                color: var(--om-blue);
                font-size: .75rem;
            }

            .customer-cell {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .customer-avatar {
                width: 35px;
                height: 35px;
                border-radius: 10px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                background: linear-gradient(135deg, var(--om-blue), var(--om-blue-dark));
                color: #fff;
                font-size: .7rem;
                font-weight: 800;
            }

            .customer-name {
                color: var(--om-text);
                font-weight: 700;
            }

            .customer-type {
                margin-top: 2px;
                color: #94a3b8;
                font-size: .65rem;
            }

            .amount-cell {
                color: var(--om-text);
                font-weight: 800;
                white-space: nowrap;
            }

            .currency {
                color: var(--om-muted);
                font-size: .68rem;
                margin-right: 2px;
            }

            /* =========================================================
               STATUS SELECT
            ========================================================= */

            .status-form {
                margin: 0;
            }

            .status-select {
                min-width: 128px;
                min-height: 36px;
                border: 1px solid var(--om-line);
                border-radius: 9px;
                padding: 5px 30px 5px 10px;
                color: var(--om-text);
                background-color: #fff;
                font-size: .7rem;
                font-weight: 700;
                cursor: pointer;
                box-shadow: none;
                transition: .15s ease;
            }

            .status-select:hover {
                border-color: #bfd3ea;
            }

            .status-select:focus {
                border-color: var(--om-blue);
                box-shadow: 0 0 0 3px rgba(13, 110, 253, .10);
            }

            /* =========================================================
               PAYMENT BADGES
            ========================================================= */

            .payment-pill {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 5px 9px;
                border-radius: 999px;
                font-size: .67rem;
                font-weight: 800;
                white-space: nowrap;
            }

            .payment-paid {
                background: var(--om-success-soft);
                border: 1px solid #c8f0dd;
                color: var(--om-success);
            }

            .payment-partial {
                background: var(--om-warning-soft);
                border: 1px solid #f7dfaa;
                color: var(--om-warning);
            }

            .payment-unpaid {
                background: var(--om-danger-soft);
                border: 1px solid #f3cccc;
                color: var(--om-danger);
            }

            .date-cell {
                white-space: nowrap;
            }

            .date-main {
                color: var(--om-text);
                font-weight: 700;
                font-size: .75rem;
            }

            .date-time {
                margin-top: 2px;
                color: #94a3b8;
                font-size: .64rem;
            }

            /* =========================================================
               RECEIPT BUTTON
            ========================================================= */

            .btn-receipt {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                min-height: 35px;
                padding: 5px 10px;
                border: 1px solid var(--om-line);
                border-radius: 9px;
                background: #fff;
                color: var(--om-text);
                text-decoration: none;
                font-size: .69rem;
                font-weight: 700;
                transition: .17s ease;
            }

            .btn-receipt:hover {
                background: var(--om-blue);
                border-color: var(--om-blue);
                color: #fff;
                transform: translateY(-1px);
            }

            /* =========================================================
               EMPTY STATE
            ========================================================= */

            .om-empty-state {
                padding: 65px 20px;
                text-align: center;
            }

            .om-empty-icon {
                width: 70px;
                height: 70px;
                margin: 0 auto 15px;
                border-radius: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--om-blue-soft);
                color: var(--om-blue);
                font-size: 1.7rem;
            }

            .om-empty-state h5 {
                margin: 0 0 5px;
                color: var(--om-text);
                font-weight: 800;
            }

            .om-empty-state p {
                margin: 0;
                color: var(--om-muted);
                font-size: .78rem;
            }

            /* =========================================================
               PAGINATION
            ========================================================= */

            .om-pagination {
                margin-top: 20px;
            }

            .om-pagination .pagination {
                gap: 5px;
                margin-bottom: 0;
            }

            .om-pagination .page-link {
                border: 1px solid var(--om-line);
                border-radius: 9px !important;
                color: var(--om-text);
                background: #fff;
                font-size: .75rem;
                font-weight: 700;
                min-width: 36px;
                text-align: center;
                transition: .15s ease;
            }

            .om-pagination .page-link:hover {
                background: var(--om-blue-soft);
                border-color: #cfe2ff;
                color: var(--om-blue);
            }

            .om-pagination .page-item.active .page-link {
                border-color: var(--om-blue);
                background: var(--om-blue);
                color: #fff;
            }

            /* =========================================================
               RESPONSIVE
            ========================================================= */

            @media (max-width: 991.98px) {
                .om-hero-stat {
                    width: 100%;
                }

                .om-filter-actions {
                    height: auto;
                }
            }

            @media (max-width: 767.98px) {
                .order-management-page {
                    padding-top: 0;
                }

                .om-hero {
                    padding: 22px 20px;
                    border-radius: 17px;
                }

                .om-hero h1 {
                    font-size: 1.55rem;
                }

                .om-filter-header,
                .om-table-header {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .om-filter-body {
                    padding: 16px;
                }

                .om-filter-actions {
                    width: 100%;
                }

                .om-filter-actions > * {
                    flex: 1;
                }

                .om-btn-primary,
                .om-btn-light,
                .om-btn-export {
                    justify-content: center;
                }

                .om-stat-card {
                    min-height: 115px;
                }

                .om-table-card {
                    border-radius: 14px;
                }
            }
        </style>

        <div class="container-fluid px-0 order-management-page">

            {{-- =====================================================
                 HERO
            ====================================================== --}}

            <div class="om-hero">
                <div class="om-hero-content">

                    <div class="row align-items-center g-4">

                        <div class="col-lg">
                            <div class="om-eyebrow">
                                <i class="bi bi-grid-1x2-fill"></i>
                                Order Operations
                            </div>

                            <h1>Order Management</h1>

                            <p>
                                Monitor sales activity, manage order statuses,
                                review payment records and generate customer receipts
                                from one centralized workspace.
                            </p>

                            <div class="om-hero-meta">
                                <span class="om-meta-chip">
                                    <i class="bi bi-shield-check"></i>
                                    Centralized control
                                </span>

                                <span class="om-meta-chip">
                                    <i class="bi bi-calendar3"></i>
                                    Date-based reporting
                                </span>

                                <span class="om-meta-chip">
                                    <i class="bi bi-receipt"></i>
                                    Receipt ready
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-auto">
                            <div class="om-hero-stat">
                                <div class="om-hero-stat-label">
                                    Total Records
                                </div>

                                <span class="om-hero-stat-value">
                                    {{ number_format($orders->total()) }}
                                </span>

                                <div class="om-hero-stat-note">
                                    Orders matching your current view
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>


            {{-- =====================================================
                 FILTERS
            ====================================================== --}}

            <div class="om-filter-card">

                <div class="om-filter-header">

                    <div class="om-section-heading">

                        <div class="om-section-icon">
                            <i class="bi bi-funnel"></i>
                        </div>

                        <div>
                            <h6>Order Filters</h6>
                            <p>Refine the order history by date range</p>
                        </div>

                    </div>

                    @if(request('start_date') || request('end_date'))
                        <span class="om-record-badge">
                            <i class="bi bi-funnel-fill"></i>
                            Filter Active
                        </span>
                    @endif

                </div>

                <div class="om-filter-body">

                    <form
                        action="{{ route('orders.index') }}"
                        method="GET"
                        class="row align-items-end g-3"
                    >

                        {{-- START DATE --}}
                        <div class="col-lg-3 col-md-6">

                            <label class="om-label">
                                Start Date
                            </label>

                            <input
                                type="date"
                                name="start_date"
                                value="{{ request('start_date') }}"
                                class="form-control om-form-control {{ request('start_date') ? 'filter-active' : '' }}"
                            >

                        </div>


                        {{-- END DATE --}}
                        <div class="col-lg-3 col-md-6">

                            <label class="om-label">
                                End Date
                            </label>

                            <input
                                type="date"
                                name="end_date"
                                value="{{ request('end_date') }}"
                                class="form-control om-form-control {{ request('end_date') ? 'filter-active' : '' }}"
                            >

                        </div>


                        {{-- ACTIONS --}}
                        <div class="col-lg-6">

                            <label class="om-label d-none d-lg-block">
                                Actions
                            </label>

                            <div class="om-filter-actions">

                                <button
                                    type="submit"
                                    class="om-btn-primary"
                                >
                                    <i class="bi bi-search me-1"></i>
                                    Apply Filters
                                </button>

                                @if(request('start_date') || request('end_date'))

                                    <a
                                        href="{{ route('orders.index') }}"
                                        class="om-btn-light"
                                    >
                                        <i class="bi bi-x-lg me-1"></i>
                                        Clear
                                    </a>

                                @endif

                                <a
                                    href="{{ route('orders.download') }}?{{ http_build_query(request()->only(['start_date', 'end_date'])) }}"
                                    class="om-btn-export"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    <i class="bi bi-file-earmark-pdf"></i>
                                    Export PDF
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =====================================================
                 SALES KPI CARDS
            ====================================================== --}}

            <div class="row g-3 mb-4">

                {{-- TODAY / SELECTED PERIOD --}}
                <div class="col-xl-4 col-md-6">

                    <div class="om-stat-card blue">

                        <div class="om-stat-icon">
                            <i class="bi bi-calendar-day"></i>
                        </div>

                        <div class="om-stat-label">
                            {{ request('start_date') ? 'Selected Period' : 'Today' }}
                        </div>

                        <div class="om-stat-value">
                            KSh {{ number_format($todaySales, 2) }}
                        </div>

                        <div class="om-stat-caption">
                            Sales recorded in the selected period
                        </div>

                    </div>

                </div>


                {{-- WEEK --}}
                <div class="col-xl-4 col-md-6">

                    <div class="om-stat-card dark">

                        <div class="om-stat-icon">
                            <i class="bi bi-calendar-week"></i>
                        </div>

                        <div class="om-stat-label">
                            This Week
                        </div>

                        <div class="om-stat-value">
                            KSh {{ number_format($weekSales, 2) }}
                        </div>

                        <div class="om-stat-caption">
                            Weekly sales performance
                        </div>

                    </div>

                </div>


                {{-- MONTH --}}
                <div class="col-xl-4 col-md-6">

                    <div class="om-stat-card">

                        <div class="om-stat-icon">
                            <i class="bi bi-calendar3"></i>
                        </div>

                        <div class="om-stat-label">
                            This Month
                        </div>

                        <div class="om-stat-value">
                            KSh {{ number_format($monthSales, 2) }}
                        </div>

                        <div class="om-stat-caption">
                            Current monthly sales
                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ORDERS TABLE
            ====================================================== --}}

            <div class="om-table-card">

                <div class="om-table-header">

                    <div class="om-table-title">

                        <div class="om-section-icon">
                            <i class="bi bi-list-check"></i>
                        </div>

                        <div>

                            <h5>
                                @if(request('start_date') || request('end_date'))

                                    Filtered Orders

                                @else

                                    Recent Orders

                                @endif
                            </h5>

                            <p>
                                Review and manage your order activity
                            </p>

                        </div>

                    </div>


                    <div class="d-flex align-items-center gap-2 flex-wrap">

                        @if(request('start_date') || request('end_date'))

                            <span class="om-record-badge">
                                <i class="bi bi-calendar-range"></i>

                                {{ request('start_date') ?? 'Start' }}

                                <span>→</span>

                                {{ request('end_date') ?? 'Now' }}
                            </span>

                        @endif

                        <span class="om-record-badge">
                            <i class="bi bi-database"></i>
                            {{ number_format($orders->total()) }}
                            {{ $orders->total() === 1 ? 'Record' : 'Records' }}
                        </span>

                    </div>

                </div>


                <div class="om-table-wrap">

                    <table class="table om-table align-middle">

                        <thead>

                            <tr>

                                <th>
                                    Invoice
                                </th>

                                <th>
                                    Customer
                                </th>

                                <th>
                                    Total
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Payment
                                </th>

                                <th>
                                    Date
                                </th>

                                <th class="text-end">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($orders as $order)

                                @php
                                    $customerName = $order->customer_name ?? 'Walk-in';

                                    $initials = collect(
                                        preg_split('/\s+/', trim($customerName))
                                    )
                                    ->filter()
                                    ->map(fn($name) => strtoupper(substr($name, 0, 1)))
                                    ->take(2)
                                    ->implode('');

                                    $status = strtolower($order->status ?? 'pending');

                                    $statusIcons = [
                                        'pending' => 'bi-clock',
                                        'processing' => 'bi-arrow-repeat',
                                        'delivered' => 'bi-truck',
                                        'cancelled' => 'bi-x-circle',
                                    ];

                                    $statusIcon = $statusIcons[$status] ?? 'bi-info-circle';
                                @endphp

                                <tr>

                                    {{-- INVOICE --}}
                                    <td>

                                        <div class="invoice-number">

                                            <span class="invoice-icon">
                                                <i class="bi bi-receipt"></i>
                                            </span>

                                            {{ $order->invoice_no }}

                                        </div>

                                    </td>


                                    {{-- CUSTOMER --}}
                                    <td>

                                        <div class="customer-cell">

                                            <div class="customer-avatar">
                                                {{ $initials ?: 'W' }}
                                            </div>

                                            <div>

                                                <div class="customer-name">
                                                    {{ $customerName }}
                                                </div>

                                                <div class="customer-type">
                                                    {{ $order->customer_name ? 'Registered Customer' : 'Walk-in Customer' }}
                                                </div>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- TOTAL --}}
                                    <td>

                                        <div class="amount-cell">

                                            <span class="currency">
                                                KSh
                                            </span>

                                            {{ number_format($order->total_amount, 2) }}

                                        </div>

                                    </td>


                                    {{-- STATUS --}}
                                    <td>

                                        <form
                                            action="{{ route('orders.updateStatus', $order->id) }}"
                                            method="POST"
                                            class="status-form"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <select
                                                name="status"
                                                class="form-select status-select"
                                                onchange="this.form.submit()"
                                                title="Update order status"
                                            >

                                                <option
                                                    value="pending"
                                                    {{ $order->status == 'pending' ? 'selected' : '' }}
                                                >
                                                    Pending
                                                </option>

                                                <option
                                                    value="processing"
                                                    {{ $order->status == 'processing' ? 'selected' : '' }}
                                                >
                                                    Processing
                                                </option>

                                                <option
                                                    value="delivered"
                                                    {{ $order->status == 'delivered' ? 'selected' : '' }}
                                                >
                                                    Delivered
                                                </option>

                                                <option
                                                    value="cancelled"
                                                    {{ $order->status == 'cancelled' ? 'selected' : '' }}
                                                >
                                                    Cancelled
                                                </option>

                                            </select>

                                        </form>

                                    </td>


                                    {{-- PAYMENT --}}
                                    <td>

                                        @if($order->payment_status == 'paid')

                                            <span class="payment-pill payment-paid">
                                                <i class="bi bi-check-circle-fill"></i>
                                                Paid
                                            </span>

                                        @elseif($order->payment_status == 'partial')

                                            <span class="payment-pill payment-partial">
                                                <i class="bi bi-circle-half"></i>
                                                Partial
                                            </span>

                                        @else

                                            <span class="payment-pill payment-unpaid">
                                                <i class="bi bi-exclamation-circle-fill"></i>
                                                Unpaid
                                            </span>

                                        @endif

                                    </td>


                                    {{-- DATE --}}
                                    <td>

                                        <div class="date-cell">

                                            <div class="date-main">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </div>

                                            <div class="date-time">
                                                {{ $order->created_at->format('h:i A') }}
                                            </div>

                                        </div>

                                    </td>


                                    {{-- RECEIPT --}}
                                    <td class="text-end">

                                        <a
                                            href="{{ route('pos.receipt', $order->id) }}"
                                            class="btn-receipt"
                                            target="_blank"
                                            rel="noopener"
                                            title="Open receipt"
                                        >
                                            <i class="bi bi-printer"></i>
                                            <span>Receipt</span>
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7">

                                        <div class="om-empty-state">

                                            <div class="om-empty-icon">
                                                <i class="bi bi-inbox"></i>
                                            </div>

                                            <h5>
                                                No Orders Found
                                            </h5>

                                            <p>
                                                No orders match the selected date range.
                                                Try adjusting your filters.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- =====================================================
                 PAGINATION
            ====================================================== --}}

            @if($orders->hasPages())

                <div class="om-pagination d-flex justify-content-center">

                    {{ $orders->appends(request()->query())->links() }}

                </div>

            @endif

        </div>

    @endsection

</x-layout>