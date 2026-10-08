<x-layout>

    @section('title', 'Manage Services')

    @section('content')

        <style>
            :root {
                --service-primary: #0d6efd;
                --service-primary-dark: #0b5ed7;
                --service-primary-soft: #eaf3ff;
                --service-navy: #071a33;
                --service-text: #162033;
                --service-muted: #718096;
                --service-border: #e6edf5;
                --service-bg: #f6f9fd;
                --service-white: #ffffff;
                --service-success: #198754;
                --service-danger: #dc3545;
            }

            .services-page {
                width: 100%;
            }

            /* -------------------------------------------------------
               PAGE HEADER
            ------------------------------------------------------- */

            .services-hero {
                position: relative;
                overflow: hidden;
                border-radius: 24px;
                padding: 28px 30px;
                margin-bottom: 24px;
                background:
                    radial-gradient(circle at 90% 10%, rgba(13, 110, 253, .16), transparent 30%),
                    linear-gradient(135deg, #ffffff 0%, #f4f8ff 100%);
                border: 1px solid var(--service-border);
                box-shadow: 0 12px 35px rgba(7, 26, 51, .06);
            }

            .services-hero::after {
                content: "";
                position: absolute;
                width: 180px;
                height: 180px;
                right: -70px;
                bottom: -100px;
                border-radius: 50%;
                background: rgba(13, 110, 253, .06);
            }

            .hero-content {
                position: relative;
                z-index: 2;
            }

            .hero-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 6px 11px;
                border-radius: 999px;
                background: var(--service-primary-soft);
                color: var(--service-primary-dark);
                font-size: .72rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .08em;
                margin-bottom: 10px;
            }

            .hero-title {
                color: var(--service-navy);
                font-size: clamp(1.55rem, 2.4vw, 2rem);
                font-weight: 800;
                margin: 0 0 7px;
                letter-spacing: -.03em;
            }

            .hero-description {
                color: var(--service-muted);
                margin: 0;
                max-width: 700px;
                font-size: .94rem;
                line-height: 1.6;
            }

            .hero-action {
                position: relative;
                z-index: 3;
            }

            .hero-action .btn {
                border-radius: 12px;
                padding: 11px 17px;
                font-weight: 700;
                box-shadow: 0 7px 18px rgba(13, 110, 253, .16);
            }

            /* -------------------------------------------------------
               STAT CARDS
            ------------------------------------------------------- */

            .service-stat {
                background: var(--service-white);
                border: 1px solid var(--service-border);
                border-radius: 18px;
                padding: 19px;
                height: 100%;
                box-shadow: 0 8px 24px rgba(7, 26, 51, .045);
                transition: .2s ease;
            }

            .service-stat:hover {
                transform: translateY(-2px);
                box-shadow: 0 14px 32px rgba(7, 26, 51, .08);
            }

            .service-stat-icon {
                width: 43px;
                height: 43px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 13px;
                background: var(--service-primary-soft);
                color: var(--service-primary);
                font-size: 1.1rem;
                margin-bottom: 12px;
            }

            .service-stat-label {
                color: var(--service-muted);
                font-size: .76rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .055em;
                margin-bottom: 3px;
            }

            .service-stat-value {
                color: var(--service-navy);
                font-size: 1.55rem;
                font-weight: 800;
                line-height: 1.1;
            }

            /* -------------------------------------------------------
               PREMIUM CARDS
            ------------------------------------------------------- */

            .service-card {
                background: var(--service-white);
                border: 1px solid var(--service-border);
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(7, 26, 51, .055);
            }

            .service-card-header {
                padding: 20px 22px;
                border-bottom: 1px solid var(--service-border);
                background: #fff;
            }

            .service-card-title {
                display: flex;
                align-items: center;
                gap: 11px;
                color: var(--service-navy);
                font-weight: 800;
                font-size: 1rem;
                margin: 0;
            }

            .service-card-title-icon {
                width: 36px;
                height: 36px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
                background: var(--service-primary-soft);
                color: var(--service-primary);
            }

            .service-card-subtitle {
                margin: 5px 0 0 47px;
                color: var(--service-muted);
                font-size: .78rem;
            }

            .service-card-body {
                padding: 22px;
            }

            /* -------------------------------------------------------
               FORM
            ------------------------------------------------------- */

            .form-label-premium {
                color: var(--service-text);
                font-size: .78rem;
                font-weight: 750;
                margin-bottom: 7px;
            }

            .form-control-premium,
            .form-select-premium {
                width: 100%;
                min-height: 45px;
                border: 1px solid #dce5ef;
                border-radius: 11px;
                background: #fbfdff;
                color: var(--service-text);
                padding: 10px 13px;
                font-size: .87rem;
                transition: .2s ease;
                outline: none;
            }

            .form-control-premium:focus,
            .form-select-premium:focus {
                border-color: var(--service-primary);
                background: #fff;
                box-shadow: 0 0 0 4px rgba(13, 110, 253, .10);
            }

            .form-control-premium::placeholder {
                color: #9aa7b7;
            }

            .input-icon-wrapper {
                position: relative;
            }

            .input-icon-wrapper > i {
                position: absolute;
                left: 13px;
                top: 50%;
                transform: translateY(-50%);
                color: #8a99aa;
                pointer-events: none;
                z-index: 2;
            }

            .input-icon-wrapper .form-control-premium {
                padding-left: 39px;
            }

            /* -------------------------------------------------------
               IMAGE UPLOAD
            ------------------------------------------------------- */

            .image-upload-box {
                position: relative;
                border: 1.5px dashed #cbd8e7;
                border-radius: 15px;
                background: #f8fbff;
                padding: 17px;
                transition: .2s ease;
            }

            .image-upload-box:hover {
                border-color: var(--service-primary);
                background: #f4f8ff;
            }

            .image-upload-content {
                display: flex;
                align-items: center;
                gap: 13px;
            }

            .upload-icon {
                width: 45px;
                height: 45px;
                min-width: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                background: #fff;
                color: var(--service-primary);
                border: 1px solid #dce7f4;
                font-size: 1.1rem;
            }

            .upload-title {
                color: var(--service-text);
                font-size: .82rem;
                font-weight: 750;
                margin-bottom: 2px;
            }

            .upload-help {
                color: var(--service-muted);
                font-size: .72rem;
                margin: 0;
            }

            .image-preview {
                display: none;
                margin-top: 13px;
                position: relative;
            }

            .image-preview img {
                width: 100%;
                height: 135px;
                object-fit: cover;
                border-radius: 12px;
                border: 1px solid var(--service-border);
            }

            .remove-preview {
                position: absolute;
                top: 7px;
                right: 7px;
                width: 28px;
                height: 28px;
                border: 0;
                border-radius: 50%;
                background: rgba(7, 26, 51, .82);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            }

            /* -------------------------------------------------------
               BUTTONS
            ------------------------------------------------------- */

            .btn-primary-premium {
                width: 100%;
                border: 0;
                min-height: 46px;
                border-radius: 11px;
                background: linear-gradient(135deg, #0d6efd, #0b5ed7);
                color: #fff;
                font-weight: 750;
                font-size: .88rem;
                box-shadow: 0 8px 18px rgba(13, 110, 253, .18);
                transition: .2s ease;
            }

            .btn-primary-premium:hover {
                color: #fff;
                transform: translateY(-1px);
                box-shadow: 0 11px 24px rgba(13, 110, 253, .25);
            }

            /* -------------------------------------------------------
               TABLE
            ------------------------------------------------------- */

            .services-table-wrapper {
                overflow-x: auto;
            }

            .services-table {
                width: 100%;
                min-width: 650px;
                border-collapse: separate;
                border-spacing: 0;
            }

            .services-table thead th {
                background: #f7faff;
                color: #718096;
                font-size: .69rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .06em;
                padding: 13px 15px;
                border-bottom: 1px solid var(--service-border);
                white-space: nowrap;
            }

            .services-table tbody td {
                padding: 15px;
                border-bottom: 1px solid #edf2f7;
                vertical-align: middle;
                color: var(--service-text);
                font-size: .84rem;
            }

            .services-table tbody tr {
                transition: .15s ease;
            }

            .services-table tbody tr:hover {
                background: #f9fbff;
            }

            .services-table tbody tr:last-child td {
                border-bottom: 0;
            }

            .service-image {
                width: 52px;
                height: 52px;
                border-radius: 13px;
                object-fit: cover;
                border: 1px solid #e2e9f2;
                box-shadow: 0 3px 9px rgba(7, 26, 51, .07);
            }

            .service-image-placeholder {
                width: 52px;
                height: 52px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 13px;
                background: var(--service-primary-soft);
                color: var(--service-primary);
                border: 1px solid #dceaff;
                font-size: 1.05rem;
            }

            .service-name {
                color: var(--service-navy);
                font-weight: 750;
                margin-bottom: 2px;
            }

            .service-meta {
                color: var(--service-muted);
                font-size: .7rem;
            }

            .price-value {
                color: var(--service-navy);
                font-weight: 800;
                white-space: nowrap;
            }

            .unit-badge {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 6px 9px;
                border-radius: 8px;
                background: #f1f6fc;
                color: #52657b;
                font-size: .7rem;
                font-weight: 750;
                text-transform: capitalize;
            }

            .action-group {
                display: flex;
                align-items: center;
                gap: 7px;
            }

            .btn-delete {
                width: 35px;
                height: 35px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 9px;
                border: 1px solid #f0d7dc;
                background: #fff7f8;
                color: var(--service-danger);
                transition: .2s ease;
            }

            .btn-delete:hover {
                background: var(--service-danger);
                border-color: var(--service-danger);
                color: #fff;
            }

            /* -------------------------------------------------------
               ALERTS
            ------------------------------------------------------- */

            .premium-alert {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                border-radius: 12px;
                border: 1px solid transparent;
                padding: 12px 13px;
                margin-bottom: 18px;
                font-size: .82rem;
            }

            .premium-alert i {
                font-size: 1rem;
                margin-top: 1px;
            }

            .premium-alert-success {
                background: #effcf5;
                border-color: #ccefe0;
                color: #137a4d;
            }

            .premium-alert-danger {
                background: #fff5f6;
                border-color: #f2d5da;
                color: #b02a37;
            }

            .premium-alert ul {
                padding-left: 17px;
            }

            /* -------------------------------------------------------
               EMPTY STATE
            ------------------------------------------------------- */

            .empty-state {
                padding: 55px 25px;
                text-align: center;
            }

            .empty-state-icon {
                width: 65px;
                height: 65px;
                margin: 0 auto 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 18px;
                background: var(--service-primary-soft);
                color: var(--service-primary);
                font-size: 1.5rem;
            }

            .empty-state h6 {
                color: var(--service-navy);
                font-weight: 800;
                margin-bottom: 6px;
            }

            .empty-state p {
                color: var(--service-muted);
                font-size: .82rem;
                margin: 0;
            }

            /* -------------------------------------------------------
               RESPONSIVE
            ------------------------------------------------------- */

            @media (max-width: 991.98px) {
                .services-hero {
                    padding: 23px;
                }

                .hero-action {
                    margin-top: 18px;
                }

                .hero-action .btn {
                    width: 100%;
                }
            }

            @media (max-width: 575.98px) {
                .services-hero {
                    border-radius: 18px;
                    padding: 20px;
                }

                .hero-title {
                    font-size: 1.45rem;
                }

                .service-card {
                    border-radius: 17px;
                }

                .service-card-header,
                .service-card-body {
                    padding: 17px;
                }

                .service-stat {
                    padding: 16px;
                }
            }
        </style>

        @php
            $serviceCount = $services->count();
            $kgServices = $services->where('unit', 'kg')->count();
            $pieceServices = $services->where('unit', 'piece')->count();
            $averagePrice = $serviceCount > 0 ? $services->avg('price') : 0;
        @endphp

        <div class="services-page">

            {{-- =====================================================
                 PAGE HERO
            ====================================================== --}}

            <div class="services-hero">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="hero-content">
                            <div class="hero-eyebrow">
                                <i class="bi bi-grid-1x2-fill"></i>
                                Service Catalog
                            </div>

                            <h1 class="hero-title">
                                Manage Laundry Services
                            </h1>

                            <p class="hero-description">
                                Create, organize and maintain the services offered by your laundry business.
                                Keep pricing and service units accurate for both POS and online orders.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="hero-action text-lg-end">
                            <a href="#add-service" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-2"></i>
                                Add New Service
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- =====================================================
                 STATISTICS
            ====================================================== --}}

            <div class="row g-3 mb-4">

                <div class="col-6 col-xl-3">
                    <div class="service-stat">
                        <div class="service-stat-icon">
                            <i class="bi bi-grid-fill"></i>
                        </div>

                        <div class="service-stat-label">
                            Total Services
                        </div>

                        <div class="service-stat-value">
                            {{ $serviceCount }}
                        </div>
                    </div>
                </div>

                <div class="col-6 col-xl-3">
                    <div class="service-stat">
                        <div class="service-stat-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <div class="service-stat-label">
                            Per Kilogram
                        </div>

                        <div class="service-stat-value">
                            {{ $kgServices }}
                        </div>
                    </div>
                </div>

                <div class="col-6 col-xl-3">
                    <div class="service-stat">
                        <div class="service-stat-icon">
                            <i class="bi bi-tag-fill"></i>
                        </div>

                        <div class="service-stat-label">
                            Per Piece
                        </div>

                        <div class="service-stat-value">
                            {{ $pieceServices }}
                        </div>
                    </div>
                </div>

                <div class="col-6 col-xl-3">
                    <div class="service-stat">
                        <div class="service-stat-icon">
                            <i class="bi bi-currency-dollar"></i>
                        </div>

                        <div class="service-stat-label">
                            Average Price
                        </div>

                        <div class="service-stat-value">
                            ${{ number_format($averagePrice, 2) }}
                        </div>
                    </div>
                </div>

            </div>

            {{-- =====================================================
                 FLASH MESSAGES
            ====================================================== --}}

            @if(session('success'))
                <div class="premium-alert premium-alert-success">
                    <i class="bi bi-check-circle-fill"></i>

                    <div>
                        <strong>Success</strong>
                        <div>{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="premium-alert premium-alert-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>

                    <div>
                        <strong>Please review the following:</strong>

                        <ul class="mb-0 mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- =====================================================
                 MAIN CONTENT
            ====================================================== --}}

            <div class="row g-4">

                {{-- =================================================
                     ADD SERVICE
                ================================================== --}}

                <div class="col-xl-4" id="add-service">

                    <div class="service-card h-100">

                        <div class="service-card-header">
                            <h5 class="service-card-title">
                                <span class="service-card-title-icon">
                                    <i class="bi bi-plus-lg"></i>
                                </span>

                                Add New Service
                            </h5>

                            <p class="service-card-subtitle">
                                Create a new service for your catalog.
                            </p>
                        </div>

                        <div class="service-card-body">

                            <form
                                action="{{ route('services.store') }}"
                                method="POST"
                                enctype="multipart/form-data"
                                id="serviceForm"
                            >
                                @csrf

                                {{-- IMAGE --}}
                                <div class="mb-4">

                                    <label class="form-label-premium">
                                        Service Image
                                    </label>

                                    <div class="image-upload-box">

                                        <div class="image-upload-content">

                                            <div class="upload-icon">
                                                <i class="bi bi-cloud-arrow-up"></i>
                                            </div>

                                            <div class="flex-grow-1">
                                                <div class="upload-title">
                                                    Upload service image
                                                </div>

                                                <p class="upload-help">
                                                    JPG or PNG · Maximum 2MB
                                                </p>
                                            </div>

                                            <label
                                                for="serviceImage"
                                                class="btn btn-sm btn-outline-primary"
                                                style="border-radius: 9px;"
                                            >
                                                Browse
                                            </label>

                                        </div>

                                        <input
                                            type="file"
                                            name="image"
                                            id="serviceImage"
                                            class="d-none"
                                            accept="image/jpeg,image/png,image/jpg"
                                        >

                                        <div class="image-preview" id="imagePreview">
                                            <img
                                                src=""
                                                alt="Service preview"
                                                id="previewImage"
                                            >

                                            <button
                                                type="button"
                                                class="remove-preview"
                                                id="removePreview"
                                                aria-label="Remove image"
                                            >
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                {{-- SERVICE NAME --}}
                                <div class="mb-3">

                                    <label
                                        for="serviceName"
                                        class="form-label-premium"
                                    >
                                        Service Name
                                    </label>

                                    <div class="input-icon-wrapper">
                                        <i class="bi bi-stars"></i>

                                        <input
                                            type="text"
                                            name="name"
                                            id="serviceName"
                                            class="form-control-premium"
                                            value="{{ old('name') }}"
                                            placeholder="e.g. Wash & Fold"
                                            maxlength="255"
                                            required
                                        >
                                    </div>

                                </div>

                                {{-- PRICE --}}
                                <div class="row g-3 mb-3">

                                    <div class="col-6">

                                        <label
                                            for="servicePrice"
                                            class="form-label-premium"
                                        >
                                            Price
                                        </label>

                                        <div class="input-icon-wrapper">
                                            <i class="bi bi-currency-dollar"></i>

                                            <input
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                name="price"
                                                id="servicePrice"
                                                class="form-control-premium"
                                                value="{{ old('price') }}"
                                                placeholder="5.00"
                                                required
                                            >
                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <label
                                            for="serviceUnit"
                                            class="form-label-premium"
                                        >
                                            Billing Unit
                                        </label>

                                        <select
                                            name="unit"
                                            id="serviceUnit"
                                            class="form-select-premium"
                                            required
                                        >
                                            <option value="kg"
                                                {{ old('unit', 'kg') === 'kg' ? 'selected' : '' }}>
                                                Kilogram
                                            </option>

                                            <option value="piece"
                                                {{ old('unit') === 'piece' ? 'selected' : '' }}>
                                                Piece
                                            </option>
                                        </select>

                                    </div>

                                </div>

                                {{-- INFO --}}
                                <div
                                    class="p-3 mb-4"
                                    style="
                                        background:#f6f9fd;
                                        border:1px solid #e7edf5;
                                        border-radius:12px;
                                    "
                                >
                                    <div class="d-flex gap-2">

                                        <i
                                            class="bi bi-info-circle-fill"
                                            style="color:#0d6efd;"
                                        ></i>

                                        <div>
                                            <div
                                                style="
                                                    color:#162033;
                                                    font-size:.75rem;
                                                    font-weight:750;
                                                    margin-bottom:2px;
                                                "
                                            >
                                                Pricing information
                                            </div>

                                            <div
                                                style="
                                                    color:#718096;
                                                    font-size:.7rem;
                                                    line-height:1.5;
                                                "
                                            >
                                                This price will be available when creating
                                                walk-in and online customer orders.
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- SUBMIT --}}
                                <button
                                    type="submit"
                                    class="btn-primary-premium"
                                >
                                    <i class="bi bi-plus-circle me-2"></i>
                                    Add Service
                                </button>

                            </form>

                        </div>
                    </div>

                </div>

                {{-- =================================================
                     SERVICE LIST
                ================================================== --}}

                <div class="col-xl-8">

                    <div class="service-card">

                        <div class="service-card-header">

                            <div class="d-flex justify-content-between align-items-center gap-3">

                                <div>
                                    <h5 class="service-card-title">
                                        <span class="service-card-title-icon">
                                            <i class="bi bi-list-ul"></i>
                                        </span>

                                        Service Catalog
                                    </h5>

                                    <p class="service-card-subtitle">
                                        All services currently available in your system.
                                    </p>
                                </div>

                                <div
                                    class="d-none d-sm-flex align-items-center gap-2"
                                    style="
                                        background:#f1f6fc;
                                        color:#52657b;
                                        border-radius:9px;
                                        padding:7px 10px;
                                        font-size:.72rem;
                                        font-weight:750;
                                    "
                                >
                                    <i class="bi bi-grid-3x3-gap-fill"></i>
                                    {{ $serviceCount }} Services
                                </div>

                            </div>

                        </div>

                        <div class="services-table-wrapper">

                            <table class="services-table">

                                <thead>
                                    <tr>
                                        <th style="width:80px;">
                                            Image
                                        </th>

                                        <th>
                                            Service
                                        </th>

                                        <th>
                                            Price
                                        </th>

                                        <th>
                                            Unit
                                        </th>

                                        <th style="width:90px;">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($services as $service)

                                        <tr>

                                            {{-- IMAGE --}}
                                            <td>

                                                @if($service->image)

                                                    <img
                                                        src="{{ asset('images/services/' . $service->image) }}"
                                                        class="service-image"
                                                        alt="{{ $service->name }}"
                                                        loading="lazy"
                                                    >

                                                @else

                                                    <div class="service-image-placeholder">
                                                        <i class="bi bi-image"></i>
                                                    </div>

                                                @endif

                                            </td>

                                            {{-- NAME --}}
                                            <td>

                                                <div class="service-name">
                                                    {{ $service->name }}
                                                </div>

                                                <div class="service-meta">
                                                    Service ID #{{ $service->id }}
                                                </div>

                                            </td>

                                            {{-- PRICE --}}
                                            <td>

                                                <span class="price-value">
                                                    ${{ number_format($service->price, 2) }}
                                                </span>

                                            </td>

                                            {{-- UNIT --}}
                                            <td>

                                                <span class="unit-badge">

                                                    @if($service->unit === 'kg')
                                                        <i class="bi bi-box-seam"></i>
                                                        Per Kilogram
                                                    @else
                                                        <i class="bi bi-tag"></i>
                                                        Per Piece
                                                    @endif

                                                </span>

                                            </td>

                                            {{-- ACTION --}}
                                            <td>

                                                <div class="action-group">

                                                    <form
                                                        action="{{ route('services.destroy', $service->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirmDelete('{{ addslashes($service->name) }}')"
                                                        class="m-0"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="btn-delete"
                                                            title="Delete service"
                                                            aria-label="Delete {{ $service->name }}"
                                                        >
                                                            <i class="bi bi-trash3"></i>
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>
                                            <td colspan="5">

                                                <div class="empty-state">

                                                    <div class="empty-state-icon">
                                                        <i class="bi bi-box-seam"></i>
                                                    </div>

                                                    <h6>
                                                        No Services Yet
                                                    </h6>

                                                    <p>
                                                        Your service catalog is currently empty.
                                                        Add your first laundry service using the form.
                                                    </p>

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

    @endsection


    @push('scripts')

        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const imageInput = document.getElementById('serviceImage');
                const imagePreview = document.getElementById('imagePreview');
                const previewImage = document.getElementById('previewImage');
                const removePreview = document.getElementById('removePreview');

                /*
                |--------------------------------------------------------------------------
                | IMAGE PREVIEW
                |--------------------------------------------------------------------------
                */

                if (imageInput) {

                    imageInput.addEventListener('change', function (event) {

                        const file = event.target.files[0];

                        if (!file) {
                            return;
                        }

                        const allowedTypes = [
                            'image/jpeg',
                            'image/png',
                            'image/jpg'
                        ];

                        if (!allowedTypes.includes(file.type)) {

                            alert('Please select a JPG or PNG image.');

                            imageInput.value = '';
                            imagePreview.style.display = 'none';

                            return;
                        }

                        if (file.size > 2 * 1024 * 1024) {

                            alert('The selected image is larger than 2MB.');

                            imageInput.value = '';
                            imagePreview.style.display = 'none';

                            return;
                        }

                        const reader = new FileReader();

                        reader.onload = function (e) {

                            previewImage.src = e.target.result;
                            imagePreview.style.display = 'block';

                        };

                        reader.readAsDataURL(file);
                    });
                }

                /*
                |--------------------------------------------------------------------------
                | REMOVE IMAGE PREVIEW
                |--------------------------------------------------------------------------
                */

                if (removePreview) {

                    removePreview.addEventListener('click', function () {

                        imageInput.value = '';
                        previewImage.src = '';
                        imagePreview.style.display = 'none';

                    });
                }

                /*
                |--------------------------------------------------------------------------
                | FORM SUBMIT FEEDBACK
                |--------------------------------------------------------------------------
                */

                const serviceForm = document.getElementById('serviceForm');

                if (serviceForm) {

                    serviceForm.addEventListener('submit', function () {

                        const submitButton = serviceForm.querySelector(
                            'button[type="submit"]'
                        );

                        if (!submitButton) {
                            return;
                        }

                        submitButton.disabled = true;

                        submitButton.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-2"></span>' +
                            'Adding Service...';

                    });
                }

            });


            /*
            |--------------------------------------------------------------------------
            | DELETE CONFIRMATION
            |--------------------------------------------------------------------------
            */

            function confirmDelete(serviceName) {

                return confirm(
                    'Delete "' + serviceName + '"?\n\n' +
                    'This action cannot be undone.'
                );
            }
        </script>

    @endpush

</x-layout>