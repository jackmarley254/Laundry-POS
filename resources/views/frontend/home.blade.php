<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SmartWash — Premium Laundry Service</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#EFF6FF',
                            100: '#DBEAFE',
                            200: '#BFDBFE',
                            300: '#93C5FD',
                            400: '#60A5FA',
                            500: '#0D6EFD',
                            600: '#0B5ED7',
                            700: '#0A4FB5',
                            800: '#0B2A4A',
                            900: '#071A33'
                        }
                    },
                    boxShadow: {
                        premium: '0 20px 60px rgba(7, 26, 51, .10)',
                        blue: '0 18px 45px rgba(13, 110, 253, .18)'
                    }
                }
            }
        };
    </script>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --navy: #071A33;
            --navy-2: #0B2A4A;
            --blue: #0D6EFD;
            --blue-dark: #0B5ED7;
            --blue-soft: #EAF3FF;
            --surface: #F5F8FC;
            --white: #FFFFFF;
            --text: #122033;
            --muted: #6B7A90;
            --border: #DCE7F5;
            --success: #16A34A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background:
                radial-gradient(circle at 10% 10%, rgba(13, 110, 253, .06), transparent 28%),
                radial-gradient(circle at 90% 20%, rgba(96, 165, 250, .08), transparent 25%),
                var(--surface);
            color: var(--text);
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: .28;
            background-image:
                linear-gradient(rgba(13, 110, 253, .025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(13, 110, 253, .025) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        .font-display {
            font-family: 'DM Serif Display', serif;
        }

        .page {
            display: none;
            opacity: 0;
            transform: translateY(18px);
            transition:
                opacity .45s ease,
                transform .45s ease;
        }

        .page.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* -------------------------------------------------------
           NAVIGATION
        ------------------------------------------------------- */

        .nav-glass {
            background: rgba(255, 255, 255, .88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(220, 231, 245, .85);
            box-shadow: 0 5px 30px rgba(7, 26, 51, .04);
        }

        .brand-logo {
            box-shadow: 0 10px 25px rgba(13, 110, 253, .22);
        }

        .nav-link {
            position: relative;
            padding: 10px 0;
            color: #52627a;
            font-size: 14px;
            font-weight: 700;
            transition: color .2s ease;
        }
        .nav-link:hover, .nav-link.active { color: var(--blue); }
        .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0; right: 0; bottom: 2px;
            height: 2px; border-radius: 999px;
            background: var(--blue);
        }
        .mobile-nav-link {
            display: flex; align-items: center; gap: 12px;
            width: 100%; padding: 13px 14px; border-radius: 12px;
            color: #334155; text-align: left; font-size: 14px; font-weight: 700;
        }
        .mobile-nav-link:hover { background: #eff6ff; color: var(--blue); }
        .contact-field {
            width: 100%; border: 1px solid #dce7f5; border-radius: 13px;
            background: #fff; padding: 13px 15px; color: #122033;
            outline: none; transition: border-color .2s, box-shadow .2s;
        }
        .contact-field:focus { border-color: #60a5fa; box-shadow: 0 0 0 4px rgba(13,110,253,.09); }
        .contact-field::placeholder { color: #94a3b8; }
        .info-card { border: 1px solid #e1eaf6; background: rgba(255,255,255,.9); box-shadow: 0 18px 45px rgba(7,26,51,.045); }

        /* -------------------------------------------------------
           PRIMARY BUTTON
        ------------------------------------------------------- */

        .glow-btn {
            position: relative;
            overflow: hidden;
            background: linear-gradient(
                135deg,
                var(--blue),
                var(--blue-dark)
            );
            transition:
                transform .3s ease,
                box-shadow .3s ease,
                opacity .3s ease;
            box-shadow: 0 10px 25px rgba(13, 110, 253, .18);
        }

        .glow-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -120%;
            width: 70%;
            height: 100%;
            transform: skewX(-20deg);
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,.22),
                transparent
            );
            transition: left .7s ease;
        }

        .glow-btn:hover::before {
            left: 140%;
        }

        .glow-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 35px rgba(13, 110, 253, .28);
        }

        .glow-btn:active {
            transform: translateY(0);
        }

        .glow-btn:disabled {
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* -------------------------------------------------------
           HERO
        ------------------------------------------------------- */

        .hero-grid {
            background-image:
                linear-gradient(rgba(13, 110, 253, .035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(13, 110, 253, .035) 1px, transparent 1px);
            background-size: 45px 45px;
        }

        .hero-title {
            color: var(--navy);
            letter-spacing: -.045em;
        }

        .hero-highlight {
            background: linear-gradient(
                135deg,
                #0D6EFD,
                #3B82F6,
                #0B5ED7
            );
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-card {
            background: rgba(255, 255, 255, .72);
            border: 1px solid rgba(220, 231, 245, .9);
            box-shadow:
                0 30px 80px rgba(7, 26, 51, .09),
                inset 0 1px 0 rgba(255,255,255,.9);
            backdrop-filter: blur(18px);
        }

        .hero-orbit {
            border: 1px solid rgba(13, 110, 253, .14);
            box-shadow:
                0 0 0 25px rgba(13, 110, 253, .025),
                0 0 0 50px rgba(13, 110, 253, .018);
        }

        .wash-drum {
            border: 3px solid rgba(13, 110, 253, .25);
            border-top-color: var(--blue);
            border-radius: 50%;
            animation: drumSpin 3s linear infinite;
        }

        .drum-inner {
            background:
                radial-gradient(circle at 35% 30%, #FFFFFF, #EAF3FF 48%, #D5E7FF);
            box-shadow:
                inset 0 0 30px rgba(13, 110, 253, .12),
                0 20px 50px rgba(13, 110, 253, .12);
        }

        @keyframes drumSpin {
            to {
                transform: rotate(360deg);
            }
        }

        /* -------------------------------------------------------
           BLOBS
        ------------------------------------------------------- */

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .30;
            pointer-events: none;
            animation: blobFloat 12s ease-in-out infinite alternate;
        }

        @keyframes blobFloat {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(30px, -40px) scale(1.1);
            }

            100% {
                transform: translate(-20px, 20px) scale(.95);
            }
        }

        /* -------------------------------------------------------
           BADGES / MICRO UI
        ------------------------------------------------------- */

        .premium-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 15px;
            border-radius: 999px;
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            color: #0B5ED7;
            font-size: .82rem;
            font-weight: 700;
        }

        .premium-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--blue);
            box-shadow: 0 0 0 5px rgba(13,110,253,.10);
            animation: pulseDot 2s infinite;
        }

        @keyframes pulseDot {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .55;
                transform: scale(.8);
            }
        }

        /* -------------------------------------------------------
           SERVICE CARDS
        ------------------------------------------------------- */

        .service-card {
            position: relative;
            overflow: hidden;
            background: rgba(255,255,255,.96);
            border: 1px solid var(--border);
            transition:
                transform .35s cubic-bezier(.4,0,.2,1),
                box-shadow .35s ease,
                border-color .35s ease;
            box-shadow: 0 10px 35px rgba(7,26,51,.045);
        }

        .service-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--blue), #60A5FA);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .35s ease;
        }

        .service-card:hover {
            border-color: #B8D4FF;
            box-shadow: 0 22px 50px rgba(7,26,51,.10);
            transform: translateY(-5px);
        }

        .service-card:hover::after {
            transform: scaleX(1);
        }

        .service-card.selected {
            border-color: var(--blue);
            background: linear-gradient(
                145deg,
                #FFFFFF,
                #F2F7FF
            );
            box-shadow: 0 20px 45px rgba(13,110,253,.12);
        }

        .service-card.selected::after {
            transform: scaleX(1);
        }

        .service-image {
            box-shadow: 0 10px 25px rgba(7,26,51,.08);
        }

        /* -------------------------------------------------------
           QUANTITY BUTTON
        ------------------------------------------------------- */

        .qty-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            color: var(--blue);
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
        }

        .qty-btn:hover {
            background: var(--blue);
            color: #fff;
            border-color: var(--blue);
            box-shadow: 0 8px 20px rgba(13,110,253,.18);
        }

        .qty-btn:active {
            transform: scale(.92);
        }

        /* -------------------------------------------------------
           HOW IT WORKS
        ------------------------------------------------------- */

        .step-card {
            position: relative;
            background: rgba(255,255,255,.88);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 28px 20px;
            box-shadow: 0 12px 35px rgba(7,26,51,.04);
            transition: all .3s ease;
        }

        .step-card:hover {
            transform: translateY(-5px);
            border-color: #B8D4FF;
            box-shadow: 0 20px 45px rgba(7,26,51,.08);
        }

        .step-icon {
            background: linear-gradient(
                145deg,
                #EFF6FF,
                #DBEAFE
            );
            border: 1px solid #BFDBFE;
            color: var(--blue);
        }

        .step-number {
            background: var(--navy);
            color: white;
            box-shadow: 0 8px 20px rgba(7,26,51,.15);
        }

        /* -------------------------------------------------------
           FORM
        ------------------------------------------------------- */

        .form-input {
            background: #FFFFFF;
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 12px;
            padding: 13px 16px;
            width: 100%;
            transition: all .25s ease;
            outline: none;
            font-size: .95rem;
            box-shadow: 0 4px 15px rgba(7,26,51,.025);
        }

        .form-input:focus {
            border-color: var(--blue);
            box-shadow:
                0 0 0 4px rgba(13,110,253,.08),
                0 8px 25px rgba(7,26,51,.04);
        }

        .form-input::placeholder {
            color: #9AA8B9;
        }

        .form-input:hover {
            border-color: #B8CCE6;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 105px;
        }

        input[type="date"],
        input[type="time"] {
            color-scheme: light;
        }

        /* -------------------------------------------------------
           CHECKOUT / SUMMARY
        ------------------------------------------------------- */

        .premium-panel {
            background: rgba(255,255,255,.96);
            border: 1px solid var(--border);
            box-shadow: 0 18px 50px rgba(7,26,51,.06);
        }

        .summary-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: #EFF6FF;
            color: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* -------------------------------------------------------
           CART BAR
        ------------------------------------------------------- */

        .cart-bar {
            background: rgba(255,255,255,.94);
            border: 1px solid #CFE0F5;
            box-shadow: 0 20px 60px rgba(7,26,51,.13);
            backdrop-filter: blur(20px);
        }

        .cart-total {
            color: var(--blue);
        }

        /* -------------------------------------------------------
           TOAST
        ------------------------------------------------------- */

        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            min-width: 280px;
            max-width: calc(100vw - 40px);
            padding: 16px 20px;
            border-radius: 15px;
            background: linear-gradient(
                135deg,
                var(--navy),
                var(--navy-2)
            );
            border: 1px solid rgba(96,165,250,.35);
            color: #fff;
            font-weight: 600;
            transform: translateY(100px);
            opacity: 0;
            transition: all .4s cubic-bezier(.4,0,.2,1);
            box-shadow: 0 20px 50px rgba(7,26,51,.25);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* -------------------------------------------------------
           PARTICLES
        ------------------------------------------------------- */

        .particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            background: radial-gradient(
                circle,
                rgba(13,110,253,.35),
                transparent
            );
            animation: particleDrift linear infinite;
        }

        @keyframes particleDrift {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* -------------------------------------------------------
           ANIMATIONS
        ------------------------------------------------------- */

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition:
                opacity .7s cubic-bezier(.4,0,.2,1),
                transform .7s cubic-bezier(.4,0,.2,1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stagger > * {
            opacity: 0;
            transform: translateY(20px);
        }

        .stagger.visible > *:nth-child(1) {
            animation: fadeUp .5s .1s forwards;
        }

        .stagger.visible > *:nth-child(2) {
            animation: fadeUp .5s .2s forwards;
        }

        .stagger.visible > *:nth-child(3) {
            animation: fadeUp .5s .3s forwards;
        }

        .stagger.visible > *:nth-child(4) {
            animation: fadeUp .5s .4s forwards;
        }

        .stagger.visible > *:nth-child(5) {
            animation: fadeUp .5s .5s forwards;
        }

        .stagger.visible > *:nth-child(6) {
            animation: fadeUp .5s .6s forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pricePulse {
            0%, 100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        .price-pulse {
            animation: pricePulse .3s ease;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* -------------------------------------------------------
           CONFIRMATION
        ------------------------------------------------------- */

        .confirmation-ring {
            position: relative;
            background: linear-gradient(
                145deg,
                #EFF6FF,
                #DBEAFE
            );
            border: 2px solid #93C5FD;
            box-shadow:
                0 0 0 12px rgba(13,110,253,.04),
                0 20px 50px rgba(13,110,253,.12);
        }

        .confirmation-check {
            background: linear-gradient(
                135deg,
                var(--blue),
                var(--blue-dark)
            );
            box-shadow: 0 12px 30px rgba(13,110,253,.25);
        }

        /* -------------------------------------------------------
           FOOTER
        ------------------------------------------------------- */

        .footer {
            background: var(--navy);
            color: #fff;
        }

        /* -------------------------------------------------------
           SCROLLBAR
        ------------------------------------------------------- */

        ::-webkit-scrollbar {
            width: 7px;
        }

        ::-webkit-scrollbar-track {
            background: #EFF4FA;
        }

        ::-webkit-scrollbar-thumb {
            background: #9ABCE8;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--blue);
        }

        @media (max-width: 768px) {
            .desktop-only {
                display: none;
            }

            .toast {
                right: 20px;
                bottom: 20px;
                left: 20px;
                min-width: auto;
            }
        }
    
        /* SmartWash navigation and footer refinement */
        .nav-glass { background: rgba(255,255,255,.94); border-bottom: 1px solid rgba(220,231,245,.8); box-shadow: 0 8px 30px rgba(7,26,51,.045); backdrop-filter: blur(18px); }
        .nav-link { position: relative; padding: 11px 14px; border-radius: 12px; color: #526176; font-size: 14px; font-weight: 800; transition: color .2s ease, background .2s ease; }
        .nav-link:hover, .nav-link.active { color: var(--blue); background: #EFF6FF; }
        .nav-link.active::after { content: ''; position: absolute; height: 3px; width: 22px; border-radius: 9px; background: var(--blue); bottom: 3px; left: calc(50% - 11px); }
        .mobile-nav-link { display: flex; align-items: center; gap: 10px; width: 100%; text-align: left; padding: 13px 14px; border-radius: 12px; color: #334155; font-size: 14px; font-weight: 800; transition: background .2s ease, color .2s ease; }
        .mobile-nav-link:hover { background: #EFF6FF; color: var(--blue); }
        .mobile-nav-order { color: #fff; background: var(--blue); }
        .mobile-nav-order:hover { color: #fff; background: var(--blue-dark); }
        .footer { background: linear-gradient(135deg, #071A33 0%, #0B2A4A 58%, #103C68 100%); color: #fff; position: relative; overflow: hidden; }
        .footer::before { content: ''; position: absolute; width: 380px; height: 380px; right: -120px; top: -180px; border-radius: 50%; background: rgba(13,110,253,.16); filter: blur(4px); pointer-events: none; }
        .footer > div { position: relative; z-index: 1; }
        .footer-link { color: rgba(219,234,254,.72); transition: color .2s ease, transform .2s ease; }
        .footer-link:hover { color: #fff; transform: translateX(3px); }
        .footer-icon { width: 36px; height: 36px; border-radius: 11px; display: inline-flex; flex: 0 0 36px; align-items: center; justify-content: center; color: #93C5FD; background: rgba(255,255,255,.08); }
        .footer-top-link { color: rgba(219,234,254,.7); font-weight: 700; transition: color .2s ease; }
        .footer-top-link:hover { color: #fff; }
</style>
</head>

<body>

<!-- ============================================================
     NAVIGATION
============================================================ -->

<nav class="nav-glass fixed top-0 left-0 w-full z-50 transition-all duration-300" id="mainNav" aria-label="Main navigation">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 py-3.5 flex items-center justify-between gap-4">
        <button type="button" onclick="showPage('landing')" class="flex items-center gap-3 group text-left" aria-label="SmartWash home">
            <span class="brand-logo w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-blue group-hover:scale-105 transition-transform">
                <i class="fas fa-shirt text-white text-lg" aria-hidden="true"></i>
            </span>
            <span class="block">
                <span class="font-display text-xl text-brand-900 block leading-none">SmartWash</span>
                <span class="text-[10px] uppercase tracking-[.18em] text-slate-500 font-extrabold block mt-1">Laundry, made smarter</span>
            </span>
        </button>

        <div class="hidden lg:flex items-center gap-2" aria-label="Website pages">
            <button type="button" onclick="showPage('landing')" class="nav-link" data-nav="landing"><i class="fas fa-house mr-2" aria-hidden="true"></i>Home</button>
            <button type="button" onclick="showPage('services')" class="nav-link" data-nav="services"><i class="fas fa-shirt mr-2" aria-hidden="true"></i>Services</button>
            <button type="button" onclick="showPage('contact')" class="nav-link" data-nav="contact"><i class="fas fa-envelope mr-2" aria-hidden="true"></i>Contact Us</button>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">
            @auth
                <a href="{{ route('pos.dashboard') }}" class="hidden md:inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-brand-600 transition-colors"><i class="fas fa-gauge-high text-brand-500" aria-hidden="true"></i> Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-brand-600 transition-colors"><i class="fas fa-lock text-brand-500" aria-hidden="true"></i> Admin Login</a>
            @endauth
            <button type="button" onclick="showPage('order')" class="glow-btn inline-flex items-center gap-2 px-4 sm:px-5 py-3 rounded-xl text-white font-extrabold text-sm"><i class="fas fa-basket-shopping" aria-hidden="true"></i><span>Place an Order</span></button>
            <button type="button" id="mobileNavToggle" onclick="toggleMobileNav()" aria-label="Open navigation menu" aria-controls="mobileNavMenu" aria-expanded="false" class="lg:hidden w-11 h-11 rounded-xl border border-slate-200 bg-white text-brand-900 flex items-center justify-center shadow-sm"><i class="fas fa-bars" aria-hidden="true"></i></button>
        </div>
    </div>
    <div id="mobileNavMenu" class="mobile-nav-menu hidden lg:hidden border-t border-slate-100 bg-white/95 backdrop-blur-xl px-5 py-4 shadow-lg">
        <div class="max-w-7xl mx-auto grid gap-2">
            <button type="button" onclick="navigateFromMobile('landing')" class="mobile-nav-link"><i class="fas fa-house w-5" aria-hidden="true"></i> Home</button>
            <button type="button" onclick="navigateFromMobile('services')" class="mobile-nav-link"><i class="fas fa-shirt w-5" aria-hidden="true"></i> Services</button>
            <button type="button" onclick="navigateFromMobile('contact')" class="mobile-nav-link"><i class="fas fa-envelope w-5" aria-hidden="true"></i> Contact Us</button>
            @auth
                <a href="{{ route('pos.dashboard') }}" class="mobile-nav-link"><i class="fas fa-gauge-high w-5" aria-hidden="true"></i> Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="mobile-nav-link"><i class="fas fa-lock w-5" aria-hidden="true"></i> Admin Login</a>
            @endauth
            <button type="button" onclick="navigateFromMobile('order')" class="mobile-nav-link mobile-nav-order"><i class="fas fa-basket-shopping w-5" aria-hidden="true"></i> Place an Order</button>
        </div>
    </div>
</nav>


<!-- ============================================================
     TOAST
============================================================ -->

<div class="toast" id="toast">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-check-circle text-blue-300"></i>
        </div>

        <span id="toastMsg"></span>
    </div>
</div>


<!-- ============================================================
     LANDING PAGE
============================================================ -->

<div class="page active" id="page-landing">

    <!-- HERO -->
    <section class="hero-grid relative min-h-screen flex items-center overflow-hidden">

        <div class="blob w-96 h-96 bg-blue-400 top-20 -left-40"></div>
        <div
            class="blob w-80 h-80 bg-sky-300 top-1/3 right-0"
            style="animation-delay:3s"
        ></div>
        <div
            class="blob w-64 h-64 bg-blue-200 bottom-20 left-1/3"
            style="animation-delay:6s"
        ></div>

        <div
            id="heroParticles"
            class="absolute inset-0 overflow-hidden pointer-events-none"
        ></div>

        <div class="max-w-7xl mx-auto px-5 sm:px-6 pt-28 pb-20 relative z-10 w-full">

            <div class="grid lg:grid-cols-2 gap-14 lg:gap-20 items-center">

                <!-- LEFT -->
                <div class="stagger" id="heroContent">

                    <div class="premium-badge mb-6">
                        <span class="dot"></span>
                        Now serving your area
                    </div>

                    <h1 class="hero-title font-display text-5xl sm:text-6xl md:text-7xl leading-[1.02] mb-6">
                        Fresh clothes,
                        <span class="hero-highlight">
                            zero effort.
                        </span>
                    </h1>

                    <p class="text-lg md:text-xl text-slate-500 leading-relaxed mb-8 max-w-xl">
                        Premium laundry and dry cleaning delivered to your door.
                        Schedule a pickup, we handle the rest.
                    </p>

                    <div class="flex flex-wrap gap-4">

                        <button
                            onclick="showPage('order')"
                            class="glow-btn px-7 sm:px-8 py-4 rounded-2xl text-white font-bold text-lg flex items-center gap-3"
                        >
                            Make an Order
                            <i class="fas fa-arrow-right text-sm"></i>
                        </button>

                        <button
                            onclick="document.getElementById('howItWorks').scrollIntoView({behavior:'smooth'})"
                            class="px-7 sm:px-8 py-4 rounded-2xl border border-slate-200 bg-white text-slate-700 font-semibold hover:border-blue-300 hover:bg-blue-50 hover:text-brand-600 transition-all flex items-center gap-3 shadow-sm"
                        >
                            <i class="fas fa-play-circle text-brand-500"></i>
                            How it works
                        </button>

                    </div>

                    <!-- TRUST POINTS -->
                    <div class="flex flex-wrap items-center gap-x-7 gap-y-4 mt-10 text-sm text-slate-500">

                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-clock text-brand-500 text-xs"></i>
                            </span>
                            24hr turnaround
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-truck text-brand-500 text-xs"></i>
                            </span>
                            Free pickup
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-shield-halved text-brand-500 text-xs"></i>
                            </span>
                            Insured
                        </div>

                    </div>

                </div>


                <!-- RIGHT HERO VISUAL -->
                <div class="relative flex items-center justify-center">

                    <div class="relative w-80 h-80 sm:w-96 sm:h-96 lg:w-[440px] lg:h-[440px]">

                        <div class="absolute inset-10 rounded-full bg-blue-100/50 blur-3xl"></div>

                        <div class="hero-orbit absolute inset-0 rounded-full"></div>

                        <div
                            class="absolute inset-8 rounded-full bg-white/75 border border-blue-100 flex items-center justify-center overflow-hidden shadow-premium backdrop-blur-xl"
                        >

                            <div
                                class="absolute w-72 h-72 rounded-full border border-dashed border-blue-200 animate-spin"
                                style="animation-duration:25s"
                            ></div>

                            <div class="wash-drum w-56 h-56 sm:w-64 sm:h-64 flex items-center justify-center">

                                <div
                                    class="drum-inner w-44 h-44 sm:w-52 sm:h-52 rounded-full flex items-center justify-center border border-blue-100"
                                >
                                    <i
                                        class="fas fa-shirt text-brand-500 text-6xl sm:text-7xl animate-bounce"
                                        style="animation-duration:2s"
                                    ></i>
                                </div>

                            </div>

                        </div>

                        <!-- Floating mini cards -->

                        <div class="absolute top-6 right-0 sm:right-2 bg-white rounded-2xl px-4 py-3 shadow-premium border border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                                    <i class="fas fa-sparkles text-brand-500"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-400">Care quality</div>
                                    <div class="font-bold text-slate-800">Premium</div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute bottom-8 left-0 sm:left-2 bg-white rounded-2xl px-4 py-3 shadow-premium border border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                                    <i class="fas fa-location-dot text-brand-500"></i>
                                </div>
                                <div>
                                    <div class="text-xs text-slate-400">Pickup</div>
                                    <div class="font-bold text-slate-800">At your door</div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>


    <!-- HOW IT WORKS -->
    <section
        id="howItWorks"
        class="py-24 relative bg-white border-y border-slate-100"
    >

        <div class="max-w-7xl mx-auto px-5 sm:px-6">

            <div class="text-center mb-16 reveal">

                <div class="text-xs uppercase tracking-[.2em] text-brand-600 font-bold mb-3">
                    Simple Process
                </div>

                <h2 class="font-display text-4xl md:text-5xl text-brand-900 mb-4">
                    How it works
                </h2>

                <p class="text-slate-500 text-lg max-w-xl mx-auto">
                    Four simple steps to fresh, clean clothes without leaving home.
                </p>

            </div>


            <div
                class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger"
                id="stepsGrid"
            >

                <div class="step-card text-center group">

                    <div class="relative inline-block mb-5">

                        <div class="step-icon w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-105 transition-all">
                            <i class="fas fa-list-check text-2xl"></i>
                        </div>

                        <span class="step-number absolute -top-2 -right-2 w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center">
                            1
                        </span>

                    </div>

                    <div class="text-brand-600 font-bold text-xs uppercase tracking-wider mb-2">
                        Choose
                    </div>

                    <h3 class="font-bold text-lg text-brand-900 mb-2">
                        Choose Services
                    </h3>

                    <p class="text-slate-500 text-sm leading-relaxed">
                        Pick from our professional laundry options.
                    </p>

                </div>


                <div class="step-card text-center group">

                    <div class="relative inline-block mb-5">

                        <div class="step-icon w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-105 transition-all">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>

                        <span class="step-number absolute -top-2 -right-2 w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center">
                            2
                        </span>

                    </div>

                    <div class="text-brand-600 font-bold text-xs uppercase tracking-wider mb-2">
                        Schedule
                    </div>

                    <h3 class="font-bold text-lg text-brand-900 mb-2">
                        Schedule Pickup
                    </h3>

                    <p class="text-slate-500 text-sm leading-relaxed">
                        Select your preferred date, time, and location.
                    </p>

                </div>


                <div class="step-card text-center group">

                    <div class="relative inline-block mb-5">

                        <div class="step-icon w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-105 transition-all">
                            <i class="fas fa-hand-sparkles text-2xl"></i>
                        </div>

                        <span class="step-number absolute -top-2 -right-2 w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center">
                            3
                        </span>

                    </div>

                    <div class="text-brand-600 font-bold text-xs uppercase tracking-wider mb-2">
                        We Handle It
                    </div>

                    <h3 class="font-bold text-lg text-brand-900 mb-2">
                        We Clean
                    </h3>

                    <p class="text-slate-500 text-sm leading-relaxed">
                        Your clothes are professionally cleaned and pressed.
                    </p>

                </div>


                <div class="step-card text-center group">

                    <div class="relative inline-block mb-5">

                        <div class="step-icon w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-105 transition-all">
                            <i class="fas fa-box-open text-2xl"></i>
                        </div>

                        <span class="step-number absolute -top-2 -right-2 w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center">
                            4
                        </span>

                    </div>

                    <div class="text-brand-600 font-bold text-xs uppercase tracking-wider mb-2">
                        Delivered
                    </div>

                    <h3 class="font-bold text-lg text-brand-900 mb-2">
                        Delivered Fresh
                    </h3>

                    <p class="text-slate-500 text-sm leading-relaxed">
                        Freshly cleaned clothes delivered to your doorstep.
                    </p>

                </div>

            </div>

        </div>
    </section>


    <!-- SERVICES -->
    <section class="py-24 relative">

        <div class="max-w-7xl mx-auto px-5 sm:px-6">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 reveal">

                <div>

                    <div class="text-xs uppercase tracking-[.2em] text-brand-600 font-bold mb-3">
                        Professional Care
                    </div>

                    <h2 class="font-display text-4xl md:text-5xl text-brand-900 mb-4">
                        Our Services
                    </h2>

                    <p class="text-slate-500 text-lg max-w-xl">
                        Professional care for every fabric, garment, and laundry need.
                    </p>

                </div>

                <div class="hidden md:flex items-center gap-2 text-sm text-slate-400">
                    <i class="fas fa-shield-halved text-brand-500"></i>
                    Quality care guaranteed
                </div>

            </div>


            <div
                class="grid md:grid-cols-3 gap-6 stagger"
                id="servicesPreview"
            ></div>


            <div class="text-center mt-12 reveal">

                <button
                    onclick="showPage('order')"
                    class="glow-btn px-8 py-4 rounded-2xl text-white font-bold text-lg inline-flex items-center gap-3"
                >
                    View All Services
                    <i class="fas fa-arrow-right"></i>
                </button>

            </div>

        </div>
    </section>


    <!-- SMARTWASH FOOTER -->
<footer class="footer mt-12" id="siteFooter">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 pt-14 pb-7">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10">
            <div class="lg:col-span-2">
                <button type="button" onclick="showPage('landing')" class="flex items-center gap-3 text-left group mb-5" aria-label="SmartWash home">
                    <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-blue group-hover:scale-105 transition-transform"><i class="fas fa-shirt text-white text-xl" aria-hidden="true"></i></span>
                    <span><span class="font-display text-2xl text-white block leading-none">SmartWash</span><span class="text-[10px] uppercase tracking-[.2em] text-blue-200/70 font-extrabold block mt-1">Laundry, made smarter</span></span>
                </button>
                <p class="text-blue-100/70 text-sm leading-7 max-w-md">Professional laundry care designed around your busy life. Enjoy fresh, clean clothes with a simple, convenient ordering experience.</p>
                <button type="button" onclick="showPage('order')" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-5 py-3 text-white text-sm font-extrabold transition"><span>Start an Order</span><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
            </div>

            <div>
                <h3 class="text-white font-extrabold text-sm mb-5">Explore SmartWash</h3>
                <ul class="grid gap-3 text-sm text-blue-100/70">
                    <li><button type="button" onclick="showPage('landing')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Home</button></li>
                    <li><button type="button" onclick="showPage('services')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Our Services</button></li>
                    <li><button type="button" onclick="showPage('contact')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Contact Us</button></li>
                    <li><button type="button" onclick="showPage('order')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Place an Order</button></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-extrabold text-sm mb-5">Get in Touch</h3>
                <ul class="grid gap-4 text-sm text-blue-100/70">
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-envelope" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Email us</span><button type="button" onclick="showPage('contact')" class="footer-link mt-1">Send us a message</button></span></li>
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-headset" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Need assistance?</span><button type="button" onclick="showPage('contact')" class="footer-link mt-1">Talk to our team</button></span></li>
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-clock" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Convenient service</span><span class="block mt-1">Order online at your convenience</span></span></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-blue-100/50">
            <p>© {{ date('Y') }} <span class="text-white font-bold">SmartWash</span>. All rights reserved.</p>
            <p class="flex items-center gap-2"><i class="fas fa-sparkles text-brand-400" aria-hidden="true"></i> Clean clothes. Clear mind. Smarter living.</p>
            <button type="button" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="footer-top-link">Back to top <i class="fas fa-arrow-up ml-1" aria-hidden="true"></i></button>
        </div>
    </div>
</footer>

</div>


<!-- ============================================================
     SERVICES PAGE — SAME SINGLE-PAGE APPLICATION
============================================================ -->
<div class="page" id="page-services">
    <section class="pt-36 pb-16 relative overflow-hidden">
        <div class="blob w-80 h-80 bg-blue-200 -top-10 -right-20"></div>
        <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center mb-12 reveal">
                <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-white px-4 py-2 text-xs font-extrabold uppercase tracking-[.16em] text-brand-600 mb-5"><i class="fas fa-sparkles"></i> Our Services</span>
                <h1 class="font-display text-4xl sm:text-5xl md:text-6xl leading-tight text-brand-900 mb-5">Expert care for <span class="text-brand-500">every fabric.</span></h1>
                <p class="text-slate-500 text-base sm:text-lg leading-8">From everyday essentials to special garments, enjoy reliable laundry care with transparent pricing and an easy online ordering experience.</p>
            </div>
            <div id="allServicesGrid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
            <div class="mt-12 rounded-3xl bg-gradient-to-r from-brand-900 to-brand-700 p-8 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-blue">
                <div><p class="text-blue-200 text-xs uppercase tracking-[.2em] font-extrabold mb-2">Ready when you are</p><h2 class="font-display text-3xl sm:text-4xl mb-2">Let us handle laundry day.</h2><p class="text-blue-100/75">Choose your services and build your order in a few simple steps.</p></div>
                <button type="button" onclick="showPage('order')" class="shrink-0 bg-white text-brand-700 hover:bg-blue-50 px-6 py-3.5 rounded-xl font-extrabold transition flex items-center gap-3">Start an Order <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </section>
    <!-- SMARTWASH FOOTER -->
<footer class="footer mt-12">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 pt-14 pb-7">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10">
            <div class="lg:col-span-2">
                <button type="button" onclick="showPage('landing')" class="flex items-center gap-3 text-left group mb-5" aria-label="SmartWash home">
                    <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-blue group-hover:scale-105 transition-transform"><i class="fas fa-shirt text-white text-xl" aria-hidden="true"></i></span>
                    <span><span class="font-display text-2xl text-white block leading-none">SmartWash</span><span class="text-[10px] uppercase tracking-[.2em] text-blue-200/70 font-extrabold block mt-1">Laundry, made smarter</span></span>
                </button>
                <p class="text-blue-100/70 text-sm leading-7 max-w-md">Professional laundry care designed around your busy life. Enjoy fresh, clean clothes with a simple, convenient ordering experience.</p>
                <button type="button" onclick="showPage('order')" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-5 py-3 text-white text-sm font-extrabold transition"><span>Start an Order</span><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
            </div>

            <div>
                <h3 class="text-white font-extrabold text-sm mb-5">Explore SmartWash</h3>
                <ul class="grid gap-3 text-sm text-blue-100/70">
                    <li><button type="button" onclick="showPage('landing')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Home</button></li>
                    <li><button type="button" onclick="showPage('services')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Our Services</button></li>
                    <li><button type="button" onclick="showPage('contact')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Contact Us</button></li>
                    <li><button type="button" onclick="showPage('order')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Place an Order</button></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-extrabold text-sm mb-5">Get in Touch</h3>
                <ul class="grid gap-4 text-sm text-blue-100/70">
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-envelope" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Email us</span><button type="button" onclick="showPage('contact')" class="footer-link mt-1">Send us a message</button></span></li>
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-headset" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Need assistance?</span><button type="button" onclick="showPage('contact')" class="footer-link mt-1">Talk to our team</button></span></li>
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-clock" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Convenient service</span><span class="block mt-1">Order online at your convenience</span></span></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-blue-100/50">
            <p>© {{ date('Y') }} <span class="text-white font-bold">SmartWash</span>. All rights reserved.</p>
            <p class="flex items-center gap-2"><i class="fas fa-sparkles text-brand-400" aria-hidden="true"></i> Clean clothes. Clear mind. Smarter living.</p>
            <button type="button" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="footer-top-link">Back to top <i class="fas fa-arrow-up ml-1" aria-hidden="true"></i></button>
        </div>
    </div>
</footer>
</div>


<!-- ============================================================
     CONTACT PAGE — SAME SINGLE-PAGE APPLICATION
============================================================ -->
<div class="page" id="page-contact">
    <section class="pt-36 pb-20 relative overflow-hidden min-h-screen">
        <div class="blob w-80 h-80 bg-sky-200 top-24 -left-24"></div>
        <div class="max-w-7xl mx-auto px-5 sm:px-6 relative z-10">
            <div class="max-w-3xl mx-auto text-center mb-12 reveal">
                <span class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-white px-4 py-2 text-xs font-extrabold uppercase tracking-[.16em] text-brand-600 mb-5"><i class="fas fa-comments"></i> Contact Us</span>
                <h1 class="font-display text-4xl sm:text-5xl md:text-6xl leading-tight text-brand-900 mb-5">We're here to <span class="text-brand-500">help.</span></h1>
                <p class="text-slate-500 text-base sm:text-lg leading-8">Questions about a service or your order? Send us a message and our team will be happy to help.</p>
            </div>
            <div class="grid lg:grid-cols-5 gap-7 items-stretch">
                <div class="lg:col-span-2 rounded-3xl bg-gradient-to-br from-brand-900 via-brand-800 to-brand-700 p-8 sm:p-9 text-white overflow-hidden relative">
                    <div class="absolute -right-12 -bottom-12 w-56 h-56 rounded-full border-[30px] border-white/5"></div>
                    <p class="text-blue-200 text-xs uppercase tracking-[.2em] font-extrabold mb-3">Get in touch</p>
                    <h2 class="font-display text-3xl mb-4">A better laundry experience starts here.</h2>
                    <p class="text-blue-100/75 leading-7 mb-9">Reach out for service information, order support, or help choosing the right laundry care.</p>
                    <div class="space-y-6 relative z-10">
                        <div class="flex items-start gap-4"><div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center shrink-0"><i class="fas fa-clock text-blue-200"></i></div><div><p class="font-bold">Service support</p><p class="text-sm text-blue-100/65 mt-1">For questions about services and orders</p></div></div>
                        <div class="flex items-start gap-4"><div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center shrink-0"><i class="fas fa-shirt text-blue-200"></i></div><div><p class="font-bold">Laundry services</p><p class="text-sm text-blue-100/65 mt-1">Everyday care, handled with attention</p></div></div>
                        <div class="flex items-start gap-4"><div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center shrink-0"><i class="fas fa-shield-heart text-blue-200"></i></div><div><p class="font-bold">Customer-first care</p><p class="text-sm text-blue-100/65 mt-1">We aim to make every step simple</p></div></div>
                    </div>
                    <button type="button" onclick="showPage('services')" class="mt-10 inline-flex items-center gap-2 text-white font-bold hover:text-blue-200">Explore our services <i class="fas fa-arrow-right text-xs"></i></button>
                </div>
                <div class="lg:col-span-3 info-card rounded-3xl p-6 sm:p-10">
                    <div class="mb-7"><h2 class="font-display text-3xl text-brand-900 mb-2">Send us a message</h2><p class="text-slate-500 text-sm">Fill in the details below. Required fields are marked.</p></div>
                    <form id="contactForm" class="space-y-5" onsubmit="submitContactForm(event)">
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div><label for="contactName" class="block text-sm font-bold text-slate-700 mb-2">Your name *</label><input id="contactName" name="name" required maxlength="100" autocomplete="name" class="contact-field" placeholder="e.g. Jane Wanjiku"></div>
                            <div><label for="contactEmail" class="block text-sm font-bold text-slate-700 mb-2">Email address *</label><input id="contactEmail" name="email" type="email" required maxlength="150" autocomplete="email" class="contact-field" placeholder="you@example.com"></div>
                        </div>
                        <div><label for="contactSubject" class="block text-sm font-bold text-slate-700 mb-2">Subject *</label><input id="contactSubject" name="subject" required maxlength="150" class="contact-field" placeholder="How can we help?"></div>
                        <div><label for="contactMessage" class="block text-sm font-bold text-slate-700 mb-2">Message *</label><textarea id="contactMessage" name="message" required maxlength="3000" rows="5" class="contact-field resize-y" placeholder="Tell us a little more about your question..."></textarea><p class="text-xs text-slate-400 mt-2">Please do not include payment card details or passwords.</p></div>
                        <button type="submit" class="glow-btn w-full sm:w-auto px-7 py-3.5 rounded-xl text-white font-extrabold inline-flex items-center justify-center gap-3">Prepare Message <i class="fas fa-paper-plane"></i></button>
                        <p class="text-xs text-slate-400 leading-5">This frontend prepares an email in your device's default email application. To deliver messages directly from the website, connect this form to a Laravel contact endpoint.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- SMARTWASH FOOTER -->
<footer class="footer mt-12">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 pt-14 pb-7">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10">
            <div class="lg:col-span-2">
                <button type="button" onclick="showPage('landing')" class="flex items-center gap-3 text-left group mb-5" aria-label="SmartWash home">
                    <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center shadow-blue group-hover:scale-105 transition-transform"><i class="fas fa-shirt text-white text-xl" aria-hidden="true"></i></span>
                    <span><span class="font-display text-2xl text-white block leading-none">SmartWash</span><span class="text-[10px] uppercase tracking-[.2em] text-blue-200/70 font-extrabold block mt-1">Laundry, made smarter</span></span>
                </button>
                <p class="text-blue-100/70 text-sm leading-7 max-w-md">Professional laundry care designed around your busy life. Enjoy fresh, clean clothes with a simple, convenient ordering experience.</p>
                <button type="button" onclick="showPage('order')" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-500 hover:bg-brand-600 px-5 py-3 text-white text-sm font-extrabold transition"><span>Start an Order</span><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
            </div>

            <div>
                <h3 class="text-white font-extrabold text-sm mb-5">Explore SmartWash</h3>
                <ul class="grid gap-3 text-sm text-blue-100/70">
                    <li><button type="button" onclick="showPage('landing')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Home</button></li>
                    <li><button type="button" onclick="showPage('services')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Our Services</button></li>
                    <li><button type="button" onclick="showPage('contact')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Contact Us</button></li>
                    <li><button type="button" onclick="showPage('order')" class="footer-link"><i class="fas fa-angle-right mr-2" aria-hidden="true"></i>Place an Order</button></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-extrabold text-sm mb-5">Get in Touch</h3>
                <ul class="grid gap-4 text-sm text-blue-100/70">
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-envelope" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Email us</span><button type="button" onclick="showPage('contact')" class="footer-link mt-1">Send us a message</button></span></li>
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-headset" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Need assistance?</span><button type="button" onclick="showPage('contact')" class="footer-link mt-1">Talk to our team</button></span></li>
                    <li class="flex items-start gap-3"><span class="footer-icon"><i class="fas fa-clock" aria-hidden="true"></i></span><span><span class="block text-white font-semibold">Convenient service</span><span class="block mt-1">Order online at your convenience</span></span></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-blue-100/50">
            <p>© {{ date('Y') }} <span class="text-white font-bold">SmartWash</span>. All rights reserved.</p>
            <p class="flex items-center gap-2"><i class="fas fa-sparkles text-brand-400" aria-hidden="true"></i> Clean clothes. Clear mind. Smarter living.</p>
            <button type="button" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="footer-top-link">Back to top <i class="fas fa-arrow-up ml-1" aria-hidden="true"></i></button>
        </div>
    </div>
</footer>
</div>


<!-- ============================================================
     ORDER PAGE
============================================================ -->

<div class="page" id="page-order">

    <section class="min-h-screen pt-28 pb-20 relative">

        <div class="blob w-72 h-72 bg-blue-300 top-40 -right-20"></div>

        <div class="max-w-5xl mx-auto px-5 sm:px-6 relative z-10">

            <div class="mb-10">

                <button
                    onclick="showPage('landing')"
                    class="text-brand-600 hover:text-brand-800 text-sm mb-5 inline-flex items-center gap-2 transition-colors font-semibold"
                >
                    <i class="fas fa-arrow-left"></i>
                    Back to Home
                </button>

                <div class="premium-badge mb-4">
                    <i class="fas fa-bag-shopping"></i>
                    Build Your Order
                </div>

                <h1 class="font-display text-4xl md:text-5xl text-brand-900 mb-3">
                    Select Your Services
                </h1>

                <p class="text-slate-500 text-lg">
                    Choose your services and set quantities.
                    Your total updates automatically.
                </p>

            </div>


            <div
                class="grid md:grid-cols-2 gap-5 mb-8"
                id="orderServicesGrid"
            ></div>


            <!-- CART -->
            <div class="sticky bottom-4 z-20 mt-10">

                <div class="cart-bar rounded-2xl p-5 sm:p-6">

                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-5">

                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-cart-shopping text-brand-500"></i>
                            </div>

                            <div>
                                <div class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                    Your Selection
                                </div>

                                <div
                                    class="font-bold text-lg text-brand-900"
                                    id="cartSummaryText"
                                >
                                    No services selected
                                </div>
                            </div>

                        </div>


                        <div class="flex items-center justify-between lg:justify-end gap-6 sm:gap-8">

                            <div class="text-left lg:text-right">

                                <div class="text-xs uppercase tracking-wider text-slate-400 font-bold mb-1">
                                    Total
                                </div>

                                <div
                                    class="font-display text-3xl cart-total"
                                    id="cartTotal"
                                >
                                    Ksh 0.00
                                </div>

                            </div>

                            <button
                                onclick="goToCheckout()"
                                class="glow-btn px-6 sm:px-8 py-3.5 rounded-xl text-white font-bold flex items-center gap-3"
                                id="checkoutBtn"
                                disabled
                                style="opacity:.4"
                            >
                                <span class="hidden sm:inline">
                                    Proceed to Checkout
                                </span>

                                <span class="sm:hidden">
                                    Checkout
                                </span>

                                <i class="fas fa-arrow-right"></i>
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>


<!-- ============================================================
     CHECKOUT PAGE
============================================================ -->

<div class="page" id="page-checkout">

    <section class="min-h-screen pt-28 pb-20 relative">

        <div class="max-w-3xl mx-auto px-5 sm:px-6 relative z-10">

            <button
                onclick="showPage('order')"
                class="text-brand-600 hover:text-brand-800 text-sm mb-5 inline-flex items-center gap-2 transition-colors font-semibold"
            >
                <i class="fas fa-arrow-left"></i>
                Back to Services
            </button>


            <div class="premium-badge mb-4">
                <i class="fas fa-lock"></i>
                Secure Checkout
            </div>


            <h1 class="font-display text-4xl md:text-5xl text-brand-900 mb-3">
                Complete Your Order
            </h1>

            <p class="text-slate-500 text-lg mb-10">
                Fill in your details and schedule a convenient pickup.
            </p>


            <!-- ORDER SUMMARY -->
            <div class="premium-panel rounded-2xl p-6 sm:p-7 mb-8">

                <h3 class="font-bold text-brand-900 mb-5 flex items-center gap-3">

                    <span class="summary-icon">
                        <i class="fas fa-receipt"></i>
                    </span>

                    Order Summary

                </h3>


                <div
                    id="checkoutSummary"
                    class="space-y-4"
                ></div>


                <div class="border-t border-slate-100 mt-5 pt-5 flex justify-between items-center">

                    <span class="font-semibold text-slate-500">
                        Total
                    </span>

                    <span
                        class="font-display text-2xl text-brand-600"
                        id="checkoutTotal"
                    >
                        Ksh 0.00
                    </span>

                </div>

            </div>


            <!-- DETAILS -->
            <form
                id="checkoutForm"
                onsubmit="submitOnlineOrder(event)"
                class="premium-panel rounded-2xl p-6 sm:p-8 space-y-7"
            >

                <div>

                    <h3 class="font-bold text-xl text-brand-900 flex items-center gap-3">
                        <span class="summary-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        Your Details
                    </h3>

                    <p class="text-sm text-slate-400 mt-2">
                        Tell us where and when we should collect your laundry.
                    </p>

                </div>


                <div class="grid md:grid-cols-2 gap-5">

                    <div>

                        <label class="block text-sm text-slate-600 font-semibold mb-2">
                            Full Name
                        </label>

                        <input
                            type="text"
                            name="customerName"
                            class="form-input"
                            placeholder="John Doe"
                            required
                        >

                    </div>


                    <div>

                        <label class="block text-sm text-slate-600 font-semibold mb-2">
                            Mobile Number
                        </label>

                        <input
                            type="tel"
                            name="mobile"
                            class="form-input"
                            placeholder="+254 712 345 678"
                            required
                        >

                    </div>

                </div>


                <div>

                    <label class="block text-sm text-slate-600 font-semibold mb-2">
                        Pickup Location
                    </label>

                    <div class="relative">

                        <i class="fas fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-brand-500 text-sm"></i>

                        <input
                            type="text"
                            name="location"
                            class="form-input pl-11"
                            placeholder="123 Main St, Westlands, Nairobi"
                            required
                        >

                    </div>

                </div>


                <div class="grid md:grid-cols-2 gap-5">

                    <div>

                        <label class="block text-sm text-slate-600 font-semibold mb-2">
                            Pickup Date
                        </label>

                        <input
                            type="date"
                            name="pickupDate"
                            class="form-input"
                            required
                        >

                    </div>


                    <div>

                        <label class="block text-sm text-slate-600 font-semibold mb-2">
                            Pickup Time
                        </label>

                        <input
                            type="time"
                            name="pickupTime"
                            class="form-input"
                            required
                        >

                    </div>

                </div>


                <div>

                    <label class="block text-sm text-slate-600 font-semibold mb-2">
                        Special Instructions
                    </label>

                    <textarea
                        name="notes"
                        class="form-input"
                        rows="3"
                        placeholder="Any special requests or instructions..."
                    ></textarea>

                </div>


                <div class="rounded-xl bg-blue-50 border border-blue-100 p-4 flex gap-3">

                    <i class="fas fa-circle-info text-brand-500 mt-0.5"></i>

                    <p class="text-sm text-slate-600 leading-relaxed">
                        Please make sure your contact details and pickup location
                        are correct so our team can reach you easily.
                    </p>

                </div>


                <button
                    type="submit"
                    class="glow-btn w-full px-8 py-4 rounded-2xl text-white font-bold text-lg flex items-center justify-center gap-3"
                    id="submitOrderBtn"
                >
                    <i class="fas fa-paper-plane"></i>
                    Submit Order
                </button>

            </form>

        </div>

    </section>

</div>


<!-- ============================================================
     CONFIRMATION
============================================================ -->

<div class="page" id="page-confirmation">

    <section class="min-h-screen flex items-center justify-center pt-28 pb-20 relative">

        <div class="max-w-lg mx-auto px-5 sm:px-6 text-center relative z-10">

            <div
                class="confirmation-ring w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-8"
            >
                <div class="confirmation-check w-16 h-16 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
            </div>


            <div class="premium-badge mb-5">
                <i class="fas fa-circle-check"></i>
                Order Confirmed
            </div>


            <h1 class="font-display text-4xl md:text-5xl text-brand-900 mb-4">
                Order Placed
            </h1>

            <p class="text-slate-500 text-lg mb-3">
                Your laundry pickup has been scheduled successfully.
            </p>

            <p class="text-slate-400 mb-8">

                Invoice:

                <span
                    class="text-brand-600 font-mono font-bold"
                    id="confirmOrderId"
                ></span>

            </p>


            <div
                class="premium-panel rounded-2xl p-6 text-left mb-8"
                id="confirmDetails"
            ></div>


            <div class="flex flex-col sm:flex-row gap-4 justify-center">

                <button
                    onclick="showPage('landing')"
                    class="glow-btn px-6 py-3 rounded-xl text-white font-semibold flex items-center justify-center gap-2"
                >
                    <i class="fas fa-home"></i>
                    Back to Home
                </button>


                <button
                    onclick="showPage('order')"
                    class="px-6 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 font-semibold hover:border-blue-300 hover:bg-blue-50 hover:text-brand-600 transition-all flex items-center justify-center gap-2"
                >
                    <i class="fas fa-plus text-brand-500"></i>
                    New Order
                </button>

            </div>

        </div>

    </section>

</div>


<script>

/* ============================================================
   SERVICE DATA
============================================================ */

let services = @json($servicesForJs);


/* ============================================================
   CART
============================================================ */

let cart = {};


/* ============================================================
   HELPERS
============================================================ */

function formatKsh(amount) {
    return 'Ksh ' + Number(amount).toLocaleString('en-KE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}


function formatTime(time) {
    if (!time) return '';

    const parts = time.split(':');

    let hour = parseInt(parts[0], 10);
    const minute = parts[1];

    const suffix = hour >= 12 ? 'PM' : 'AM';

    hour = hour % 12 || 12;

    return `${hour}:${minute} ${suffix}`;
}


function formatDate(date) {
    if (!date) return '';

    return new Date(date + 'T00:00:00').toLocaleDateString(
        'en-KE',
        {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        }
    );
}


function todayStr() {
    const date = new Date();

    const year = date.getFullYear();

    const month = String(
        date.getMonth() + 1
    ).padStart(2, '0');

    const day = String(
        date.getDate()
    ).padStart(2, '0');

    return `${year}-${month}-${day}`;
}


/* ============================================================
   TOAST
============================================================ */

function showToast(message) {

    const toast = document.getElementById('toast');

    const toastMessage = document.getElementById('toastMsg');

    if (!toast || !toastMessage) return;

    toastMessage.textContent = message;

    toast.classList.add('show');

    clearTimeout(window.toastTimer);

    window.toastTimer = setTimeout(() => {
        toast.classList.remove('show');
    }, 3500);
}


/* ============================================================
   PAGE NAVIGATION
============================================================ */

function showPage(pageId, updateHistory = true) {
    const allowedPages = ['landing', 'services', 'contact', 'order', 'checkout', 'confirmation'];
    if (!allowedPages.includes(pageId)) pageId = 'landing';

    document.querySelectorAll('.page').forEach(page => page.classList.remove('active'));
    const page = document.getElementById('page-' + pageId);
    if (!page) return;

    requestAnimationFrame(() => page.classList.add('active'));
    window.scrollTo({ top: 0, behavior: 'smooth' });

    document.querySelectorAll('[data-nav]').forEach(link => {
        link.classList.toggle('active', link.getAttribute('data-nav') === pageId);
    });
    closeMobileNav();

    if (updateHistory) {
        const url = new URL(window.location.href);
        url.hash = pageId === 'landing' ? '' : pageId;
        window.history.pushState({ pageId }, '', url);
    }

    if (pageId === 'order') renderOrderPage();
    if (pageId === 'checkout') renderCheckoutPage();
    if (pageId === 'landing') {
        renderLandingServices();
        setTimeout(() => initLandingAnimations(), 100);
    }
    if (pageId === 'services') {
        renderAllServices();
        setTimeout(() => initLandingAnimations(), 100);
    }
}

function toggleMobileNav() {
    const menu = document.getElementById('mobileNavMenu');
    const toggle = document.getElementById('mobileNavToggle');
    if (!menu || !toggle) return;
    const willOpen = menu.classList.contains('hidden');
    menu.classList.toggle('hidden', !willOpen);
    toggle.setAttribute('aria-expanded', String(willOpen));
    toggle.setAttribute('aria-label', willOpen ? 'Close navigation' : 'Open navigation');
    toggle.innerHTML = willOpen ? '<i class="fas fa-xmark"></i>' : '<i class="fas fa-bars"></i>';
}

function closeMobileNav() {
    const menu = document.getElementById('mobileNavMenu');
    const toggle = document.getElementById('mobileNavToggle');
    if (menu) menu.classList.add('hidden');
    if (toggle) {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Open navigation');
        toggle.innerHTML = '<i class="fas fa-bars"></i>';
    }
}

function navigateFromMobile(pageId) {
    showPage(pageId);
}

function renderAllServices() {
    const container = document.getElementById('allServicesGrid');
    if (!container) return;
    if (!Array.isArray(services) || services.length === 0) {
        container.innerHTML = `<div class="sm:col-span-2 lg:col-span-3 text-center py-14 px-6 rounded-3xl bg-white border border-blue-100"><div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-4"><i class="fas fa-shirt text-brand-500 text-2xl"></i></div><h3 class="font-bold text-brand-900 text-lg mb-2">Services coming soon</h3><p class="text-slate-500">Please check back shortly for our available laundry services.</p></div>`;
        return;
    }
    container.innerHTML = services.map(service => `
        <article class="service-card rounded-2xl p-6 sm:p-7 group cursor-pointer" onclick="showPage('order')">
            <div class="relative h-52 rounded-2xl overflow-hidden mb-6 bg-blue-50">
                <img src="${escapeHtml(service.image || '')}" alt="${escapeHtml(service.name || 'Laundry service')}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.style.display='none'">
                <div class="absolute top-3 left-3 rounded-full bg-white/95 backdrop-blur px-3 py-1.5 text-[10px] uppercase tracking-wider text-brand-600 font-extrabold">Professional care</div>
            </div>
            <h3 class="font-bold text-xl text-brand-900 mb-2">${escapeHtml(service.name || 'Laundry service')}</h3>
            <p class="text-slate-500 text-sm leading-6 mb-5">Thoughtful care and a convenient way to keep your items fresh, clean, and ready to wear.</p>
            <div class="flex items-end justify-between border-t border-slate-100 pt-5"><div><span class="block text-xs text-slate-400 mb-1">Starting from</span><span class="font-display text-2xl text-brand-600">${formatKsh(service.price || 0)}</span><span class="text-xs text-slate-400"> / ${escapeHtml(service.unit || 'item')}</span></div><span class="w-10 h-10 rounded-xl bg-blue-50 text-brand-600 flex items-center justify-center group-hover:bg-brand-500 group-hover:text-white transition"><i class="fas fa-arrow-right"></i></span></div>
        </article>`).join('');
}

function submitContactForm(event) {
    event.preventDefault();
    const form = event.currentTarget;
    if (!form.reportValidity()) return;
    const data = new FormData(form);
    const name = String(data.get('name') || '').trim();
    const email = String(data.get('email') || '').trim();
    const subject = String(data.get('subject') || '').trim();
    const message = String(data.get('message') || '').trim();
    if (!name || !email || !subject || !message) {
        showToast('Please complete all required fields.');
        return;
    }
    const recipient = @json(config('mail.from.address'));
    if (!recipient) {
        showToast('The contact email is not configured yet. Please contact the business administrator.');
        return;
    }
    const body = `Name: ${name}\nEmail: ${email}\n\n${message}`;
    const mailto = `mailto:${recipient}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.location.href = mailto;
    showToast('Opening your email application to send the message.');
}


/* ============================================================
   LANDING SERVICES
============================================================ */

function renderLandingServices() {

    const container = document.getElementById('servicesPreview');

    if (!container) return;


    if (services.length === 0) {

        container.innerHTML = `
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shirt text-brand-500 text-xl"></i>
                </div>

                <p class="text-slate-400">
                    No services available yet.
                </p>
            </div>
        `;

        return;
    }


    container.innerHTML = services
        .slice(0, 3)
        .map(service => `

            <div
                class="service-card rounded-2xl p-6 text-center group cursor-pointer"
                onclick="showPage('order')"
            >

                <div class="relative w-20 h-20 rounded-2xl overflow-hidden mx-auto mb-5 service-image bg-blue-50">

                    <img
                        src="${service.image}"
                        alt="${escapeHtml(service.name)}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                    >

                </div>


                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-brand-600 text-[10px] uppercase tracking-wider font-bold mb-3">
                    Professional Care
                </div>


                <h3 class="font-bold text-lg text-brand-900 mb-2">
                    ${escapeHtml(service.name)}
                </h3>


                <div class="text-brand-600 font-display text-2xl mb-1">
                    ${formatKsh(service.price)}
                </div>


                <div class="text-slate-400 text-sm">
                    per ${escapeHtml(service.unit)}
                </div>


                <div class="mt-5 pt-4 border-t border-slate-100 text-sm text-brand-600 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                    Order this service
                    <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </div>

            </div>

        `)
        .join('');
}


/* ============================================================
   LANDING ANIMATIONS
============================================================ */

function initLandingAnimations() {

    const hero = document.getElementById('heroContent');

    if (hero) {
        setTimeout(() => {
            hero.classList.add('visible');
        }, 200);
    }


    const observer = new IntersectionObserver(
        entries => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }

            });

        },
        {
            threshold: .15
        }
    );


    document
        .querySelectorAll('.reveal, .stagger')
        .forEach(element => {
            observer.observe(element);
        });


    createHeroParticles();
}


/* ============================================================
   HERO PARTICLES
============================================================ */

function createHeroParticles() {

    const container =
        document.getElementById('heroParticles');

    if (!container || container.children.length > 0) {
        return;
    }


    for (let i = 0; i < 20; i++) {

        const particle =
            document.createElement('div');

        particle.className = 'particle';


        const size =
            Math.random() * 4 + 2;


        particle.style.cssText = `
            width:${size}px;
            height:${size}px;
            left:${Math.random() * 100}%;
            bottom:-10px;
            animation-duration:${Math.random() * 8 + 6}s;
            animation-delay:${Math.random() * 5}s;
        `;


        container.appendChild(particle);
    }
}


/* ============================================================
   ORDER PAGE
============================================================ */

function renderOrderPage() {

    const container =
        document.getElementById('orderServicesGrid');

    if (!container) return;


    if (services.length === 0) {

        container.innerHTML = `
            <div class="col-span-full text-center py-16">
                <div class="w-20 h-20 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-shirt text-brand-500 text-2xl"></i>
                </div>

                <h3 class="font-bold text-lg text-brand-900 mb-2">
                    No services available
                </h3>

                <p class="text-slate-400">
                    Please check back soon.
                </p>
            </div>
        `;

        updateCartSummary();

        return;
    }


    container.innerHTML = services
        .map(service => {

            const quantity =
                cart[service.id] || 0;


            return `

                <div class="service-card rounded-2xl p-5 ${
                    quantity > 0 ? 'selected' : ''
                }">

                    <div class="flex items-start gap-4">

                        <div class="relative w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0 bg-blue-50 service-image">

                            <img
                                src="${service.image}"
                                alt="${escapeHtml(service.name)}"
                                class="w-full h-full object-cover"
                            >

                        </div>


                        <div class="flex-1 min-w-0">

                            <div class="flex items-start justify-between gap-3">

                                <div>

                                    <h3 class="font-bold text-lg text-brand-900 mb-1">
                                        ${escapeHtml(service.name)}
                                    </h3>

                                    <div class="flex items-baseline gap-2 mb-4">

                                        <span class="text-brand-600 font-display text-xl">
                                            ${formatKsh(service.price)}
                                        </span>

                                        <span class="text-slate-400 text-sm">
                                            / ${escapeHtml(service.unit)}
                                        </span>

                                    </div>

                                </div>

                                ${
                                    quantity > 0
                                    ? `
                                        <span class="w-7 h-7 rounded-full bg-brand-500 text-white flex items-center justify-center text-xs">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    `
                                    : ''
                                }

                            </div>


                            <div class="flex items-center gap-3">

                                <button
                                    type="button"
                                    class="qty-btn"
                                    onclick="changeQty(${service.id}, -1)"
                                    aria-label="Decrease quantity"
                                >
                                    <i class="fas fa-minus text-xs"></i>
                                </button>


                                <span class="font-bold text-lg text-brand-900 w-8 text-center">
                                    ${quantity}
                                </span>


                                <button
                                    type="button"
                                    class="qty-btn"
                                    onclick="changeQty(${service.id}, 1)"
                                    aria-label="Increase quantity"
                                >
                                    <i class="fas fa-plus text-xs"></i>
                                </button>


                                <span class="text-slate-400 text-sm ml-1">
                                    ${escapeHtml(service.unit)}${quantity !== 1 ? 's' : ''}
                                </span>

                            </div>

                        </div>

                    </div>


                    ${
                        quantity > 0
                        ? `

                            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">

                                <span class="text-slate-400 text-sm">
                                    Subtotal
                                </span>

                                <span class="text-brand-600 font-bold">
                                    ${formatKsh(service.price * quantity)}
                                </span>

                            </div>

                        `
                        : ''
                    }

                </div>

            `;

        })
        .join('');


    updateCartSummary();
}


/* ============================================================
   CHANGE QUANTITY
============================================================ */

function changeQty(id, difference) {

    if (!cart[id]) {
        cart[id] = 0;
    }


    cart[id] =
        Math.max(
            0,
            cart[id] + difference
        );


    if (cart[id] === 0) {
        delete cart[id];
    }


    renderOrderPage();
}


/* ============================================================
   CART TOTAL
============================================================ */

function getCartTotal() {

    return Object.keys(cart).reduce(
        (total, id) => {

            const service =
                services.find(
                    item => item.id === parseInt(id)
                );


            if (!service) {
                return total;
            }


            return total +
                service.price *
                cart[id];

        },
        0
    );
}


function updateCartSummary() {

    const selected =
        Object.keys(cart)
            .filter(id => cart[id] > 0);


    const total =
        getCartTotal();


    const summary =
        document.getElementById(
            'cartSummaryText'
        );


    const totalElement =
        document.getElementById(
            'cartTotal'
        );


    const checkoutButton =
        document.getElementById(
            'checkoutBtn'
        );


    if (
        !summary ||
        !totalElement ||
        !checkoutButton
    ) {
        return;
    }


    if (selected.length === 0) {

        summary.textContent =
            'No services selected';

        totalElement.textContent =
            'Ksh 0.00';

        checkoutButton.disabled =
            true;

        checkoutButton.style.opacity =
            '.4';

        return;
    }


    summary.textContent =
        selected.length +
        ' service' +
        (selected.length > 1 ? 's' : '') +
        ' selected';


    totalElement.textContent =
        formatKsh(total);


    checkoutButton.disabled =
        false;

    checkoutButton.style.opacity =
        '1';


    totalElement.classList.add(
        'price-pulse'
    );


    setTimeout(() => {

        totalElement.classList.remove(
            'price-pulse'
        );

    }, 300);
}


/* ============================================================
   CHECKOUT NAVIGATION
============================================================ */

function goToCheckout() {

    const selected =
        Object.keys(cart)
            .filter(id => cart[id] > 0);


    if (selected.length === 0) {

        showToast(
            'Please select at least one service'
        );

        return;
    }


    showPage('checkout');
}


/* ============================================================
   CHECKOUT SUMMARY
============================================================ */

function renderCheckoutPage() {

    const summary =
        document.getElementById(
            'checkoutSummary'
        );


    const totalElement =
        document.getElementById(
            'checkoutTotal'
        );


    if (!summary || !totalElement) {
        return;
    }


    let total = 0;

    let html = '';


    Object.keys(cart).forEach(id => {

        const service =
            services.find(
                item => item.id === parseInt(id)
            );


        if (!service) {
            return;
        }


        const subtotal =
            service.price * cart[id];


        total += subtotal;


        html += `

            <div class="flex justify-between items-center gap-4">

                <div class="flex items-center gap-3 min-w-0">

                    <div class="summary-icon flex-shrink-0">
                        <i class="fas fa-shirt text-sm"></i>
                    </div>

                    <div class="min-w-0">

                        <span class="font-semibold text-brand-900 block truncate">
                            ${escapeHtml(service.name)}
                        </span>

                        <span class="text-slate-400 text-sm">
                            x${cart[id]} ${escapeHtml(service.unit)}${cart[id] > 1 ? 's' : ''}
                        </span>

                    </div>

                </div>


                <span class="text-brand-700 font-bold whitespace-nowrap">
                    ${formatKsh(subtotal)}
                </span>

            </div>

        `;
    });


    summary.innerHTML =
        html ||
        `
            <p class="text-slate-400">
                No services selected.
            </p>
        `;


    totalElement.textContent =
        formatKsh(total);


    const dateInput =
        document.querySelector(
            'input[name="pickupDate"]'
        );


    if (dateInput) {
        dateInput.min = todayStr();
    }
}


/* ============================================================
   SUBMIT ONLINE ORDER
============================================================ */

function submitOnlineOrder(event) {

    event.preventDefault();


    const form =
        event.target;


    const button =
        document.getElementById(
            'submitOrderBtn'
        );


    const selected =
        Object.keys(cart)
            .filter(id => cart[id] > 0);


    if (selected.length === 0) {

        showToast(
            'Your cart is empty'
        );

        return;
    }


    const orderData = {

        customer_name:
            form.customerName.value.trim(),

        phone:
            form.mobile.value.trim(),

        location:
            form.location.value.trim(),

        pickup_date:
            form.pickupDate.value,

        pickup_time:
            form.pickupTime.value,

        notes:
            form.notes.value.trim(),

        services:
            selected.map(id => {

                const service =
                    services.find(
                        item =>
                            item.id === parseInt(id)
                    );


                return {
                    id: service.id,
                    quantity: cart[id]
                };

            })

    };


    button.disabled = true;

    button.innerHTML = `
        <span class="spinner"></span>
        Submitting...
    `;


    fetch(
        "{{ route('online-orders.store') }}",
        {
            method: 'POST',

            headers: {
                'Content-Type':
                    'application/json',

                'Accept':
                    'application/json',

                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
            },

            body:
                JSON.stringify(orderData)
        }
    )

    .then(async response => {

        const data =
            await response.json();


        if (!response.ok) {

            const firstError =
                data.errors
                    ? Object.values(data.errors)[0][0]
                    : (
                        data.message ||
                        'Unable to submit your order.'
                    );


            throw new Error(
                firstError
            );
        }


        return data;

    })

    .then(data => {

        button.disabled = false;


        button.innerHTML = `
            <i class="fas fa-paper-plane"></i>
            Submit Order
        `;


        form.reset();

        cart = {};


        showConfirmation({

            invoice_number:
                data.order.order_number,

            customer_name:
                data.order.customer_name,

            mobile:
                data.order.phone,

            location:
                data.order.delivery_address,

            pickup_date:
                data.order.pickup_date,

            pickup_time:
                data.order.pickup_time,

            total:
                data.order.total_amount

        });

    })

    .catch(error => {

        console.error(
            'Order submission error:',
            error
        );


        button.disabled = false;


        button.innerHTML = `
            <i class="fas fa-paper-plane"></i>
            Submit Order
        `;


        showToast(
            error.message ||
            'Something went wrong while submitting your order.'
        );

    });
}


/* ============================================================
   CONFIRMATION
============================================================ */

function showConfirmation(order) {

    const invoice =
        order.invoice_number ||
        order.id ||
        'Pending';


    const customerName =
        order.customer_name ||
        'Customer';


    const mobile =
        order.mobile ||
        '—';


    const location =
        order.location ||
        '—';


    const pickupDate =
        order.pickup_date ||
        '';


    const pickupTime =
        order.pickup_time ||
        '';


    const total =
        Number(order.total || 0);


    document.getElementById(
        'confirmOrderId'
    ).textContent = invoice;


    document.getElementById(
        'confirmDetails'
    ).innerHTML = `

        <div class="space-y-4 text-sm">

            <div class="flex justify-between gap-4">

                <span class="text-slate-400">
                    Name
                </span>

                <span class="font-semibold text-brand-900 text-right">
                    ${escapeHtml(customerName)}
                </span>

            </div>


            <div class="flex justify-between gap-4">

                <span class="text-slate-400">
                    Mobile
                </span>

                <span class="font-semibold text-brand-900 text-right">
                    ${escapeHtml(mobile)}
                </span>

            </div>


            <div class="flex justify-between gap-4">

                <span class="text-slate-400">
                    Location
                </span>

                <span class="font-semibold text-brand-900 text-right max-w-[65%]">
                    ${escapeHtml(location)}
                </span>

            </div>


            <div class="flex justify-between gap-4">

                <span class="text-slate-400">
                    Pickup
                </span>

                <span class="font-semibold text-brand-900 text-right">
                    ${formatDate(pickupDate)}
                    ${pickupTime ? ' at ' + formatTime(pickupTime) : ''}
                </span>

            </div>


            <div class="border-t border-slate-100 pt-4 flex justify-between items-center">

                <span class="text-slate-500 font-semibold">
                    Total
                </span>

                <span class="font-display text-xl text-brand-600">
                    ${formatKsh(total)}
                </span>

            </div>

        </div>

    `;


    showPage('confirmation');
}


/* ============================================================
   BASIC HTML ESCAPING
============================================================ */

function escapeHtml(value) {

    const div =
        document.createElement('div');


    div.textContent =
        value ?? '';


    return div.innerHTML;
}


/* ============================================================
   INITIALIZATION
============================================================ */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        renderLandingServices();

        setTimeout(
            initLandingAnimations,
            100
        );


        const nav =
            document.getElementById(
                'mainNav'
            );


        window.addEventListener(
            'scroll',
            function () {

                if (!nav) return;


                if (window.scrollY > 50) {

                    nav.style.background =
                        'rgba(255,255,255,.96)';

                    nav.style.boxShadow =
                        '0 10px 35px rgba(7,26,51,.08)';

                } else {

                    nav.style.background =
                        'rgba(255,255,255,.88)';

                    nav.style.boxShadow =
                        '0 5px 30px rgba(7,26,51,.04)';
                }

            }
        );


        const pickupDate =
            document.querySelector(
                'input[name="pickupDate"]'
            );


        if (pickupDate) {
            pickupDate.min = todayStr();
        }

        const initialPage = window.location.hash.replace('#', '');
        if (['services', 'contact', 'order', 'checkout', 'confirmation'].includes(initialPage)) {
            showPage(initialPage, false);
        }

        window.addEventListener('popstate', function (event) {
            const fromState = event.state && event.state.pageId;
            const fromHash = window.location.hash.replace('#', '');
            const target = fromState || fromHash || 'landing';
            showPage(target, false);
        });

    }
);

</script>

</body>
</html>