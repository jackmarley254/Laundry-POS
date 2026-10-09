<x-layout>

    @section('title', 'Point of Sale')

    @section('content')

        <style>
            :root {
                --pos-navy: #071a33;
                --pos-navy-2: #0b2a4a;
                --pos-blue: #0d6efd;
                --pos-blue-dark: #0b5ed7;
                --pos-blue-soft: #eaf3ff;
                --pos-bg: #f4f8fc;
                --pos-white: #ffffff;
                --pos-text: #162033;
                --pos-muted: #718096;
                --pos-border: #e3eaf2;
                --pos-success: #198754;
                --pos-danger: #dc3545;
            }

            /* =========================================================
               POS ROOT
            ========================================================= */

            .pos-terminal {
                display: flex;
                width: 100%;
                height: calc(100vh - 120px);
                min-height: 650px;
                margin: -20px;
                width: calc(100% + 40px);
                background: var(--pos-bg);
                overflow: hidden;
                color: var(--pos-text);
            }

            /* =========================================================
               SERVICES AREA
            ========================================================= */

            .pos-services-panel {
                flex: 1;
                min-width: 0;
                display: flex;
                flex-direction: column;
                overflow: hidden;
                background:
                    radial-gradient(
                        circle at 10% 0%,
                        rgba(13, 110, 253, .055),
                        transparent 28%
                    ),
                    var(--pos-bg);
            }

            .services-topbar {
                padding: 22px 25px 18px;
                background: rgba(255,255,255,.96);
                border-bottom: 1px solid var(--pos-border);
                flex-shrink: 0;
            }

            .pos-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 5px 9px;
                border-radius: 999px;
                background: var(--pos-blue-soft);
                color: var(--pos-blue-dark);
                font-size: .65rem;
                font-weight: 800;
                letter-spacing: .08em;
                text-transform: uppercase;
                margin-bottom: 7px;
            }

            .pos-page-title {
                margin: 0;
                color: var(--pos-navy);
                font-size: 1.45rem;
                font-weight: 850;
                letter-spacing: -.03em;
            }

            .pos-page-description {
                margin: 3px 0 0;
                color: var(--pos-muted);
                font-size: .78rem;
            }

            .service-search-wrapper {
                position: relative;
                width: min(360px, 100%);
            }

            .service-search-wrapper > i {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: #8b99aa;
                pointer-events: none;
            }

            .service-search {
                width: 100%;
                height: 43px;
                padding: 0 15px 0 40px;
                border: 1px solid var(--pos-border);
                border-radius: 11px;
                background: #f9fbfd;
                color: var(--pos-text);
                outline: none;
                font-size: .82rem;
                transition: .2s ease;
            }

            .service-search:focus {
                background: #fff;
                border-color: var(--pos-blue);
                box-shadow: 0 0 0 4px rgba(13,110,253,.09);
            }

            .service-search::placeholder {
                color: #9aa7b7;
            }

            .services-scroll-area {
                flex: 1;
                overflow-y: auto;
                padding: 23px 25px;
            }

            .services-scroll-area::-webkit-scrollbar {
                width: 7px;
            }

            .services-scroll-area::-webkit-scrollbar-track {
                background: transparent;
            }

            .services-scroll-area::-webkit-scrollbar-thumb {
                background: #ccd6e2;
                border-radius: 20px;
            }

            /* =========================================================
               SERVICE CARDS
            ========================================================= */

            .pos-service-card {
                position: relative;
                height: 100%;
                min-height: 185px;
                background: #fff;
                border: 1px solid var(--pos-border);
                border-radius: 17px;
                padding: 15px;
                cursor: pointer;
                overflow: hidden;
                transition:
                    transform .2s ease,
                    box-shadow .2s ease,
                    border-color .2s ease;
            }

            .pos-service-card::after {
                content: "";
                position: absolute;
                right: -25px;
                bottom: -35px;
                width: 95px;
                height: 95px;
                border-radius: 50%;
                background: rgba(13,110,253,.035);
                pointer-events: none;
            }

            .pos-service-card:hover {
                transform: translateY(-4px);
                border-color: rgba(13,110,253,.35);
                box-shadow: 0 14px 30px rgba(7,26,51,.09);
            }

            .pos-service-card:active {
                transform: translateY(-1px) scale(.99);
            }

            .service-image {
                width: 74px;
                height: 74px;
                margin: 0 auto 13px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 16px;
                background: var(--pos-blue-soft);
                border: 1px solid #dbeaff;
                overflow: hidden;
            }

            .service-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .service-image i {
                color: var(--pos-blue);
                font-size: 1.7rem;
                opacity: .75;
            }

            .service-card-name {
                color: var(--pos-navy);
                font-size: .84rem;
                font-weight: 800;
                margin-bottom: 5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .service-card-price {
                color: var(--pos-blue);
                font-size: .87rem;
                font-weight: 850;
            }

            .service-card-unit {
                color: var(--pos-muted);
                font-size: .67rem;
                margin-top: 2px;
            }

            .service-add-icon {
                position: absolute;
                top: 11px;
                right: 11px;
                width: 27px;
                height: 27px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 8px;
                background: #f5f8fc;
                color: var(--pos-blue);
                font-size: .78rem;
                transition: .2s ease;
            }

            .pos-service-card:hover .service-add-icon {
                background: var(--pos-blue);
                color: #fff;
            }

            /* =========================================================
               NO SEARCH RESULTS
            ========================================================= */

            .no-services-found {
                display: none;
                padding: 70px 20px;
                text-align: center;
            }

            .no-services-icon {
                width: 65px;
                height: 65px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 15px;
                border-radius: 18px;
                background: var(--pos-blue-soft);
                color: var(--pos-blue);
                font-size: 1.4rem;
            }

            .no-services-found h6 {
                color: var(--pos-navy);
                font-weight: 800;
                margin-bottom: 5px;
            }

            .no-services-found p {
                color: var(--pos-muted);
                font-size: .78rem;
                margin: 0;
            }

            /* =========================================================
               CART PANEL
            ========================================================= */

            .pos-cart-panel {
                width: 440px;
                min-width: 440px;
                display: flex;
                flex-direction: column;
                background: #fff;
                border-left: 1px solid var(--pos-border);
                box-shadow: -12px 0 35px rgba(7,26,51,.06);
                z-index: 5;
            }

            .cart-top {
                padding: 20px;
                border-bottom: 1px solid var(--pos-border);
                background: #fff;
                flex-shrink: 0;
            }

            .cart-title {
                display: flex;
                align-items: center;
                gap: 10px;
                color: var(--pos-navy);
                font-size: 1rem;
                font-weight: 850;
                margin: 0;
            }

            .cart-title-icon {
                width: 36px;
                height: 36px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
                background: var(--pos-blue-soft);
                color: var(--pos-blue);
            }

            .cart-count {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 24px;
                height: 24px;
                padding: 0 7px;
                border-radius: 999px;
                background: var(--pos-blue);
                color: #fff;
                font-size: .67rem;
                font-weight: 800;
            }

            .btn-clear-cart {
                border: 1px solid #f0d7dc;
                background: #fff7f8;
                color: var(--pos-danger);
                border-radius: 9px;
                padding: 7px 10px;
                font-size: .7rem;
                font-weight: 750;
                transition: .2s ease;
            }

            .btn-clear-cart:hover {
                background: var(--pos-danger);
                border-color: var(--pos-danger);
                color: #fff;
            }

            /* =========================================================
               CUSTOMER BOX
            ========================================================= */

            .customer-panel {
                margin-top: 17px;
                padding: 14px;
                background: #f7faff;
                border: 1px solid #e5edf7;
                border-radius: 14px;
            }

            .customer-panel-label {
                display: flex;
                align-items: center;
                gap: 7px;
                color: var(--pos-navy);
                font-size: .7rem;
                font-weight: 800;
                margin-bottom: 10px;
            }

            .customer-panel-label i {
                color: var(--pos-blue);
            }

            .pos-input-wrapper {
                position: relative;
            }

            .pos-input-wrapper > i {
                position: absolute;
                left: 13px;
                top: 50%;
                transform: translateY(-50%);
                color: #8c9bad;
                pointer-events: none;
                z-index: 2;
            }

            .pos-input {
                width: 100%;
                height: 42px;
                padding: 0 12px 0 38px;
                border: 1px solid #dce5ef;
                border-radius: 9px;
                background: #fff;
                color: var(--pos-text);
                font-size: .78rem;
                outline: none;
                transition: .2s ease;
            }

            .pos-input:focus {
                border-color: var(--pos-blue);
                box-shadow: 0 0 0 3px rgba(13,110,253,.09);
            }

            .pos-input::placeholder {
                color: #9ba8b7;
            }

            /* =========================================================
               CART BODY
            ========================================================= */

            .cart-form {
                flex: 1;
                min-height: 0;
                display: flex;
                flex-direction: column;
            }

            .cart-body {
                flex: 1;
                min-height: 0;
                overflow-y: auto;
                padding: 17px 20px;
                background: #f8fbfe;
            }

            .cart-body::-webkit-scrollbar {
                width: 6px;
            }

            .cart-body::-webkit-scrollbar-thumb {
                background: #d0dae6;
                border-radius: 20px;
            }

            /* =========================================================
               EMPTY CART
            ========================================================= */

            .empty-cart {
                min-height: 260px;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                flex-direction: column;
            }

            .empty-cart-icon {
                width: 70px;
                height: 70px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 20px;
                background: #edf4fb;
                color: #91a2b6;
                font-size: 1.6rem;
                margin-bottom: 15px;
            }

            .empty-cart h6 {
                color: var(--pos-navy);
                font-size: .85rem;
                font-weight: 800;
                margin-bottom: 5px;
            }

            .empty-cart p {
                color: var(--pos-muted);
                font-size: .73rem;
                margin: 0;
            }

            /* =========================================================
               CART ITEMS
            ========================================================= */

            .cart-item {
                background: #fff;
                border: 1px solid #e3eaf2;
                border-radius: 14px;
                padding: 13px;
                margin-bottom: 11px;
                animation: cartItemIn .22s ease-out;
                box-shadow: 0 4px 12px rgba(7,26,51,.035);
            }

            @keyframes cartItemIn {
                from {
                    opacity: 0;
                    transform: translateY(7px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .cart-item-name {
                color: var(--pos-navy);
                font-size: .8rem;
                font-weight: 800;
                margin: 0 0 3px;
            }

            .cart-item-price {
                color: var(--pos-blue);
                font-size: .68rem;
                font-weight: 700;
            }

            .cart-remove {
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 0;
                border-radius: 8px;
                background: #f8f9fb;
                color: #8a98a9;
                transition: .2s ease;
            }

            .cart-remove:hover {
                background: #fff0f2;
                color: var(--pos-danger);
            }

            /* =========================================================
               QUANTITY
            ========================================================= */

            .quantity-control {
                display: flex;
                align-items: center;
                height: 34px;
                border: 1px solid #dce5ef;
                border-radius: 9px;
                overflow: hidden;
                background: #f9fbfd;
            }

            .quantity-btn {
                width: 32px;
                height: 100%;
                border: 0;
                background: transparent;
                color: var(--pos-blue);
                font-size: .95rem;
                font-weight: 800;
                cursor: pointer;
                transition: .15s ease;
            }

            .quantity-btn:hover {
                background: var(--pos-blue-soft);
            }

            .quantity-input {
                width: 42px;
                height: 100%;
                border: 0;
                outline: none;
                background: transparent;
                text-align: center;
                color: var(--pos-navy);
                font-size: .76rem;
                font-weight: 800;
            }

            .cart-subtotal {
                color: var(--pos-navy);
                font-size: .86rem;
                font-weight: 850;
            }

            /* =========================================================
               CART FOOTER
            ========================================================= */

            .cart-footer {
                padding: 17px 20px 20px;
                background: #fff;
                border-top: 1px solid var(--pos-border);
                flex-shrink: 0;
            }

            .totals-box {
                padding: 14px;
                border-radius: 13px;
                background:
                    linear-gradient(
                        135deg,
                        #f6f9fd,
                        #eef5ff
                    );
                border: 1px solid #e0eaf5;
                margin-bottom: 13px;
            }

            .total-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                color: var(--pos-muted);
                font-size: .75rem;
                margin-bottom: 7px;
            }

            .total-row:last-child {
                margin-bottom: 0;
            }

            .grand-total-row {
                padding-top: 9px;
                margin-top: 9px;
                border-top: 1px dashed #cfd9e6;
            }

            .grand-total-label {
                color: var(--pos-navy);
                font-size: .85rem;
                font-weight: 850;
            }

            .grand-total {
                color: var(--pos-blue);
                font-size: 1.3rem;
                font-weight: 900;
                letter-spacing: -.02em;
            }

            .payment-label {
                color: var(--pos-muted);
                font-size: .68rem;
                font-weight: 750;
                margin-bottom: 5px;
            }

            .payment-input {
                height: 43px;
                width: 100%;
                border: 1px solid #dce5ef;
                border-radius: 9px;
                text-align: center;
                font-size: .85rem;
                font-weight: 850;
                color: var(--pos-navy);
                outline: none;
            }

            .payment-input:focus {
                border-color: var(--pos-blue);
                box-shadow: 0 0 0 3px rgba(13,110,253,.09);
            }

            .btn-exact {
                width: 100%;
                height: 43px;
                border: 1px solid #b9d4f7;
                border-radius: 9px;
                background: #f5f9ff;
                color: var(--pos-blue-dark);
                font-size: .73rem;
                font-weight: 800;
                transition: .2s ease;
            }

            .btn-exact:hover {
                background: var(--pos-blue);
                border-color: var(--pos-blue);
                color: #fff;
            }

            .btn-process {
                width: 100%;
                min-height: 47px;
                border: 0;
                border-radius: 10px;
                background: linear-gradient(
                    135deg,
                    #0d6efd 0%,
                    #0b5ed7 100%
                );
                color: #fff;
                font-size: .83rem;
                font-weight: 850;
                letter-spacing: .01em;
                box-shadow: 0 8px 20px rgba(13,110,253,.22);
                transition: .2s ease;
            }

            .btn-process:hover {
                color: #fff;
                transform: translateY(-1px);
                box-shadow: 0 11px 25px rgba(13,110,253,.28);
            }

            .btn-process:disabled {
                opacity: .7;
                transform: none;
            }

            /* =========================================================
               RESPONSIVE
            ========================================================= */

            @media (max-width: 1199.98px) {
                .pos-cart-panel {
                    width: 390px;
                    min-width: 390px;
                }

                .pos-service-card {
                    min-height: 175px;
                }
            }

            @media (max-width: 991.98px) {

                .pos-terminal {
                    height: auto;
                    min-height: 0;
                    overflow: visible;
                    flex-direction: column;
                }

                .pos-services-panel {
                    min-height: 600px;
                }

                .pos-cart-panel {
                    width: 100%;
                    min-width: 0;
                    border-left: 0;
                    border-top: 1px solid var(--pos-border);
                }

                .cart-form {
                    min-height: 500px;
                }

                .services-topbar {
                    padding: 18px;
                }

                .services-scroll-area {
                    padding: 18px;
                }
            }

            @media (max-width: 575.98px) {

                .pos-terminal {
                    margin: -12px;
                    width: calc(100% + 24px);
                }

                .services-topbar {
                    padding: 17px 15px;
                }

                .services-scroll-area {
                    padding: 15px;
                }

                .pos-page-title {
                    font-size: 1.2rem;
                }

                .service-search-wrapper {
                    width: 100%;
                    margin-top: 15px;
                }

                .pos-cart-panel {
                    box-shadow: none;
                }

                .cart-top,
                .cart-footer {
                    padding-left: 15px;
                    padding-right: 15px;
                }

                .cart-body {
                    padding-left: 15px;
                    padding-right: 15px;
                }
            }
        </style>


        <div class="pos-terminal">

            {{-- =====================================================
                 SERVICES PANEL
            ====================================================== --}}

            <section class="pos-services-panel">

                {{-- TOP BAR --}}
                <div class="services-topbar">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <div>
                            <div class="pos-eyebrow">
                                <i class="bi bi-lightning-charge-fill"></i>
                                Quick Sales
                            </div>

                            <h1 class="pos-page-title">
                                Point of Sale
                            </h1>

                            <p class="pos-page-description">
                                Select a laundry service to add it to the current order.
                            </p>
                        </div>

                        <div class="service-search-wrapper">
                            <i class="bi bi-search"></i>

                            <input
                                type="text"
                                id="searchServiceInput"
                                class="service-search"
                                placeholder="Search services..."
                                autocomplete="off"
                            >
                        </div>

                    </div>

                </div>


                {{-- SERVICES GRID --}}
                <div class="services-scroll-area">

                    <div
                        class="row g-3"
                        id="serviceContainer"
                    >

                        @foreach($services as $service)

                            <div
                                class="col-xl-3 col-lg-4 col-md-4 col-sm-6 service-col"
                                data-name="{{ strtolower($service->name) }}"
                            >

                                <div
                                    class="pos-service-card"
                                    onclick="addToCart(
                                        '{{ $service->id }}',
                                        @json($service->name),
                                        {{ $service->price }}
                                    )"
                                >

                                    <div class="service-add-icon">
                                        <i class="bi bi-plus-lg"></i>
                                    </div>

                                    <div class="service-image">

                                        @if($service->image)

                                            <img
                                                src="{{ asset('images/services/' . $service->image) }}"
                                                alt="{{ $service->name }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <i class="bi bi-box-seam"></i>

                                        @endif

                                    </div>

                                    <div class="service-card-name">
                                        {{ $service->name }}
                                    </div>

                                    <div class="service-card-price">
                                        KSh {{ number_format($service->price, 2) }}
                                    </div>

                                    <div class="service-card-unit">
                                        Per {{ ucfirst($service->unit) }}
                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    {{-- NO RESULTS --}}
                    <div
                        class="no-services-found"
                        id="noServicesFound"
                    >

                        <div class="no-services-icon">
                            <i class="bi bi-search"></i>
                        </div>

                        <h6>
                            No services found
                        </h6>

                        <p>
                            Try searching with a different service name.
                        </p>

                    </div>

                </div>

            </section>


            {{-- =====================================================
                 CART / ORDER PANEL
            ====================================================== --}}

            <aside class="pos-cart-panel">

                {{-- CART HEADER --}}
                <div class="cart-top">

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-2">

                            <h2 class="cart-title">

                                <span class="cart-title-icon">
                                    <i class="bi bi-bag-check-fill"></i>
                                </span>

                                Current Order

                            </h2>

                            <span
                                class="cart-count"
                                id="cartCount"
                            >
                                0
                            </span>

                        </div>

                        <button
                            type="button"
                            class="btn-clear-cart"
                            onclick="clearCart()"
                        >
                            <i class="bi bi-trash3 me-1"></i>
                            Clear
                        </button>

                    </div>


                    {{-- CUSTOMER --}}
                    <div class="customer-panel">

                        <div class="customer-panel-label">
                            <i class="bi bi-person-badge-fill"></i>
                            Customer Information
                        </div>

                        {{-- PHONE --}}
                        <div class="pos-input-wrapper mb-2">

                            <i class="bi bi-phone-fill"></i>

                            <input
                                type="text"
                                id="search_phone"
                                class="pos-input"
                                placeholder="Customer phone number"
                                autocomplete="off"
                                required
                            >

                        </div>

                        <div class="row g-2">

                            {{-- CUSTOMER NAME --}}
                            <div class="col-7">

                                <div class="pos-input-wrapper">

                                    <i class="bi bi-person-fill"></i>

                                    <input
                                        type="text"
                                        id="customer_name"
                                        class="pos-input"
                                        placeholder="Customer name"
                                        required
                                    >

                                </div>

                            </div>

                            {{-- PICKUP DATE --}}
                            <div class="col-5">

                                <div class="pos-input-wrapper">

                                    <i class="bi bi-calendar-event-fill"></i>

                                    <input
                                        type="date"
                                        id="pickup_date"
                                        class="pos-input"
                                        required
                                    >

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     ORDER FORM
                ================================================== --}}

                <form
                    action="{{ route('pos.store') }}"
                    method="POST"
                    id="posForm"
                    class="cart-form"
                >

                    @csrf

                    {{-- HIDDEN CUSTOMER VALUES --}}
                    <input
                        type="hidden"
                        name="customer_phone"
                        id="customer_phone_hidden"
                    >

                    <input
                        type="hidden"
                        name="customer_name"
                        id="customer_name_hidden"
                    >

                    <input
                        type="hidden"
                        name="pickup_date"
                        id="pickup_date_hidden"
                    >


                    {{-- =================================================
                         CART BODY
                    ================================================== --}}

                    <div
                        class="cart-body"
                        id="cartContainer"
                    >

                        {{-- EMPTY STATE --}}
                        <div
                            id="emptyState"
                            class="empty-cart"
                        >

                            <div class="empty-cart-icon">
                                <i class="bi bi-cart3"></i>
                            </div>

                            <h6>
                                Your order is empty
                            </h6>

                            <p>
                                Select services from the catalog to get started.
                            </p>

                        </div>


                        {{-- DYNAMIC CART ITEMS --}}
                        <div id="cartItems"></div>

                    </div>


                    {{-- =================================================
                         CART FOOTER
                    ================================================== --}}

                    <div class="cart-footer">

                        {{-- TOTALS --}}
                        <div class="totals-box">

                            <div class="total-row">

                                <span>
                                    Subtotal
                                </span>

                                <span id="subTotalDisplay">
                                    KSh 0.00
                                </span>

                            </div>

                            <div class="total-row grand-total-row">

                                <span class="grand-total-label">
                                    Total
                                </span>

                                <span
                                    class="grand-total"
                                    id="grandTotal"
                                >
                                    KSh 0.00
                                </span>

                            </div>

                        </div>


                        {{-- PAYMENT --}}
                        <div class="row g-2 align-items-end">

                            <div class="col-5">

                                <label
                                    class="payment-label"
                                    for="paid_amount"
                                >
                                    Payment Amount
                                </label>

                                <input
                                    type="number"
                                    name="paid_amount"
                                    id="paid_amount"
                                    step="0.01"
                                    min="0"
                                    value="0"
                                    class="payment-input"
                                >

                            </div>

                            <div class="col-7">

                                <button
                                    type="button"
                                    class="btn-exact mb-2"
                                    onclick="setExactAmount()"
                                >
                                    <i class="bi bi-bullseye me-1"></i>
                                    Exact Amount
                                </button>

                                <button
                                    type="submit"
                                    class="btn-process"
                                    id="processOrderButton"
                                >
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    Process Order
                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </aside>

        </div>


    @endsection


    @push('scripts')

        <script>
            $(document).ready(function () {

                /*
                |--------------------------------------------------------------------------
                | INITIAL STATE
                |--------------------------------------------------------------------------
                */

                window.rowIndex = 0;

                const today = new Date().toISOString().split('T')[0];

                $('#pickup_date').val(today);

                /*
                |--------------------------------------------------------------------------
                | LIVE SERVICE SEARCH
                |--------------------------------------------------------------------------
                */

                $('#searchServiceInput').on('input', function () {

                    const value = $(this).val().toLowerCase().trim();

                    let visibleCount = 0;

                    $('#serviceContainer .service-col').each(function () {

                        const serviceName = $(this)
                            .data('name')
                            .toString()
                            .toLowerCase();

                        const matches = serviceName.indexOf(value) !== -1;

                        $(this).toggle(matches);

                        if (matches) {
                            visibleCount++;
                        }

                    });

                    if (visibleCount === 0) {
                        $('#noServicesFound').show();
                    } else {
                        $('#noServicesFound').hide();
                    }

                });


                /*
                |--------------------------------------------------------------------------
                | CUSTOMER SEARCH
                |--------------------------------------------------------------------------
                */

                let customerSearchTimer = null;

                $('#search_phone').on('input', function () {

                    const query = $(this).val().trim();

                    clearTimeout(customerSearchTimer);

                    if (query.length <= 2) {
                        return;
                    }

                    customerSearchTimer = setTimeout(function () {

                        $.ajax({

                            url: "{{ route('pos.searchCustomer') }}",

                            type: "GET",

                            data: {
                                query: query
                            },

                            success: function (data) {

                                if (
                                    Array.isArray(data) &&
                                    data.length > 0
                                ) {

                                    $('#customer_name')
                                        .val(data[0].name || '');

                                }

                            },

                            error: function () {

                                console.log(
                                    'Customer lookup unavailable.'
                                );

                            }

                        });

                    }, 350);

                });


                /*
                |--------------------------------------------------------------------------
                | ADD TO CART
                |--------------------------------------------------------------------------
                */

                window.addToCart = function (id, name, price) {

                    $('#emptyState').hide();

                    window.rowIndex++;

                    const currentIdx = window.rowIndex;

                    const numericPrice = parseFloat(price) || 0;

                    const itemHtml = `
                        <div
                            class="cart-item"
                            id="row${currentIdx}"
                            data-price="${numericPrice}"
                        >

                            <div class="d-flex justify-content-between align-items-start mb-2">

                                <div class="pe-2">

                                    <h6 class="cart-item-name">
                                        ${escapeHtml(name)}
                                    </h6>

                                    <div class="cart-item-price">
                                        KSh ${numericPrice.toFixed(2)} per unit
                                    </div>

                                </div>

                                <button
                                    type="button"
                                    class="cart-remove"
                                    onclick="removeRow(${currentIdx})"
                                    title="Remove item"
                                >
                                    <i class="bi bi-x-lg"></i>
                                </button>

                            </div>


                            <div class="d-flex justify-content-between align-items-center">

                                <div class="quantity-control">

                                    <button
                                        type="button"
                                        class="quantity-btn"
                                        onclick="updateQty(${currentIdx}, -1)"
                                    >
                                        −
                                    </button>

                                    <input
                                        type="number"
                                        step="0.1"
                                        min="0.1"
                                        value="1"
                                        class="quantity-input qty-display"
                                        id="qty${currentIdx}"
                                        name="items[${currentIdx}][quantity]"
                                        onchange="calculateTotals()"
                                    >

                                    <button
                                        type="button"
                                        class="quantity-btn"
                                        onclick="updateQty(${currentIdx}, 1)"
                                    >
                                        +
                                    </button>

                                </div>


                                <input
                                    type="hidden"
                                    name="items[${currentIdx}][service_id]"
                                    value="${id}"
                                >


                                <span class="cart-subtotal subtotal">
                                    KSh ${numericPrice.toFixed(2)}
                                </span>

                            </div>

                        </div>
                    `;

                    $('#cartItems').append(itemHtml);

                    calculateTotals();

                };


                /*
                |--------------------------------------------------------------------------
                | UPDATE QUANTITY
                |--------------------------------------------------------------------------
                */

                window.updateQty = function (id, change) {

                    const input = $(`#qty${id}`);

                    if (!input.length) {
                        return;
                    }

                    let currentVal = parseFloat(input.val());

                    if (isNaN(currentVal)) {
                        currentVal = 1;
                    }

                    let newVal = currentVal + change;

                    if (newVal > 0) {

                        input.val(newVal);

                        calculateTotals();

                    } else {

                        removeRow(id);

                    }

                };


                /*
                |--------------------------------------------------------------------------
                | REMOVE ITEM
                |--------------------------------------------------------------------------
                */

                window.removeRow = function (id) {

                    const row = $(`#row${id}`);

                    row.fadeOut(200, function () {

                        $(this).remove();

                        calculateTotals();

                        updateCartState();

                    });

                };


                /*
                |--------------------------------------------------------------------------
                | CLEAR CART
                |--------------------------------------------------------------------------
                */

                window.clearCart = function () {

                    if ($('#cartItems').children().length === 0) {
                        return;
                    }

                    const confirmed = confirm(
                        'Clear all items from the current order?'
                    );

                    if (!confirmed) {
                        return;
                    }

                    $('#cartItems').empty();

                    $('#emptyState').show();

                    calculateTotals();

                    updateCartState();

                };


                /*
                |--------------------------------------------------------------------------
                | CALCULATE TOTALS
                |--------------------------------------------------------------------------
                */

                window.calculateTotals = function () {

                    let total = 0;

                    let itemCount = 0;

                    $('#cartItems .cart-item').each(function () {

                        const item = $(this);

                        const qty = parseFloat(
                            item.find('.qty-display').val()
                        ) || 0;

                        const price = parseFloat(
                            item.data('price')
                        ) || 0;

                        const subtotal = price * qty;

                        item.find('.subtotal').text(
                            'KSh ' + subtotal.toFixed(2)
                        );

                        total += subtotal;

                        itemCount++;

                    });

                    $('#subTotalDisplay').text(
                        'KSh ' + total.toFixed(2)
                    );

                    $('#grandTotal').text(
                        'KSh ' + total.toFixed(2)
                    );

                    $('#cartCount').text(itemCount);

                };


                /*
                |--------------------------------------------------------------------------
                | CART STATE
                |--------------------------------------------------------------------------
                */

                function updateCartState() {

                    const itemCount =
                        $('#cartItems .cart-item').length;

                    $('#cartCount').text(itemCount);

                    if (itemCount === 0) {
                        $('#emptyState').show();
                    } else {
                        $('#emptyState').hide();
                    }

                }


                /*
                |--------------------------------------------------------------------------
                | EXACT PAYMENT
                |--------------------------------------------------------------------------
                */

                window.setExactAmount = function () {

                    const totalText =
                        $('#grandTotal').text();

                    const amount = parseFloat(
                        totalText.replace(/[^0-9.-]+/g, '')
                    );

                    if (!isNaN(amount)) {

                        $('#paid_amount').val(
                            amount.toFixed(2)
                        );

                        $('#paid_amount').trigger('focus');

                    }

                };


                /*
                |--------------------------------------------------------------------------
                | FORM SUBMISSION
                |--------------------------------------------------------------------------
                */

                $('#posForm').on('submit', function (e) {

                    const customerName =
                        $('#customer_name').val().trim();

                    const phone =
                        $('#search_phone').val().trim();

                    const pickupDate =
                        $('#pickup_date').val();

                    const itemCount =
                        $('#cartItems .cart-item').length;

                    if (!customerName || !phone) {

                        e.preventDefault();

                        alert(
                            'Please enter the customer name and phone number.'
                        );

                        return false;

                    }

                    if (!pickupDate) {

                        e.preventDefault();

                        alert(
                            'Please select a pickup date.'
                        );

                        return false;

                    }

                    if (itemCount === 0) {

                        e.preventDefault();

                        alert(
                            'Your cart is empty. Please select at least one service.'
                        );

                        return false;

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | COPY CUSTOMER INFORMATION TO HIDDEN FORM INPUTS
                    |--------------------------------------------------------------------------
                    */

                    $('#customer_phone_hidden')
                        .val(phone);

                    $('#customer_name_hidden')
                        .val(customerName);

                    $('#pickup_date_hidden')
                        .val(pickupDate);


                    /*
                    |--------------------------------------------------------------------------
                    | PREVENT DOUBLE SUBMISSION
                    |--------------------------------------------------------------------------
                    */

                    const submitButton =
                        $('#processOrderButton');

                    submitButton.prop('disabled', true);

                    submitButton.html(
                        '<span class="spinner-border spinner-border-sm me-2"></span>' +
                        'Processing Order...'
                    );

                });


                /*
                |--------------------------------------------------------------------------
                | HTML ESCAPE
                |--------------------------------------------------------------------------
                */

                window.escapeHtml = function (value) {

                    return $('<div>')
                        .text(value)
                        .html();

                };


                /*
                |--------------------------------------------------------------------------
                | INITIAL TOTALS
                |--------------------------------------------------------------------------
                */

                calculateTotals();

            });
        </script>

    @endpush

</x-layout>