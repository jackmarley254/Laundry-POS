<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>LaundryPOS — Laundry Service</title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: {
                        200: '#bbf7d0',
                        300: '#86efac',
                        400: '#4ade80',
                        500: '#22c55e',
                        600: '#16a34a',
                        700: '#15803d',
                        800: '#166534',
                        900: '#14532d'
                    }
                }
            }
        }
    }
</script>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
>

<link
    href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
>

<style>
    :root {
        --bg: #0a0f0d;
        --fg: #f0fdf6;
        --muted: #86efad;
        --accent: #22c55e;
        --card: rgba(22, 101, 52, .12);
        --border: rgba(34, 197, 94, .20);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--fg); overflow-x: hidden; }
    .font-display { font-family: 'DM Serif Display', serif; }

    body::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        opacity: .5;
    }

    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: .15;
        pointer-events: none;
        animation: blobFloat 12s ease-in-out infinite alternate;
    }

    @keyframes blobFloat {
        0% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(30px, -40px) scale(1.1); }
        100% { transform: translate(-20px, 20px) scale(.95); }
    }

    .page { display: none; opacity: 0; transform: translateY(20px); transition: opacity .5s ease, transform .5s ease; }
    .page.active { display: block; opacity: 1; transform: translateY(0); }

    .glow-btn {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        transition: all .3s ease;
    }
    .glow-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(34, 197, 94, .4); }

    .service-card {
        background: var(--card);
        border: 1px solid var(--border);
        transition: all .35s cubic-bezier(.4, 0, .2, 1);
    }
    .service-card:hover { border-color: rgba(34, 197, 94, .5); box-shadow: 0 0 30px rgba(34, 197, 94, .08); transform: translateY(-4px); }
    .service-card.selected { border-color: #22c55e; background: rgba(34, 197, 94, .1); box-shadow: 0 0 40px rgba(34, 197, 94, .12); }

    .qty-btn {
        width: 36px; height: 36px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        background: rgba(34, 197, 94, .15);
        border: 1px solid rgba(34, 197, 94, .3);
        color: #22c55e; font-weight: 700; cursor: pointer; transition: all .2s;
    }
    .qty-btn:hover { background: rgba(34, 197, 94, .3); }
    .qty-btn:active { transform: scale(.92); }

    .reveal { opacity: 0; transform: translateY(30px); transition: all .7s cubic-bezier(.4, 0, .2, 1); }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    .toast {
        position: fixed; bottom: 30px; right: 30px; z-index: 9999;
        padding: 16px 24px; border-radius: 12px;
        background: linear-gradient(135deg, #166534, #15803d);
        border: 1px solid rgba(34, 197, 94, .4);
        color: #f0fdf6; font-weight: 500;
        transform: translateY(100px); opacity: 0;
        transition: all .4s cubic-bezier(.4, 0, .2, 1);
        box-shadow: 0 10px 40px rgba(0, 0, 0, .4);
    }
    .toast.show { transform: translateY(0); opacity: 1; }

    .form-input {
        background: rgba(34, 197, 94, .06);
        border: 1px solid var(--border);
        color: var(--fg);
        border-radius: 10px;
        padding: 12px 16px;
        width: 100%;
        transition: all .3s;
        outline: none;
        font-size: .95rem;
    }
    .form-input:focus { border-color: #22c55e; box-shadow: 0 0 20px rgba(34, 197, 94, .1); }
    .form-input::placeholder { color: rgba(134, 239, 173, .4); }

    .particle {
        position: absolute; border-radius: 50%; pointer-events: none;
        background: radial-gradient(circle, rgba(34, 197, 94, .6), transparent);
        animation: particleDrift linear infinite;
    }
    @keyframes particleDrift {
        0% { transform: translateY(0) rotate(0deg); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
    }

    .spinner {
        width: 20px; height: 20px; border: 2px solid transparent; border-top-color: #fff;
        border-radius: 50%; animation: spin .6s linear infinite; display: inline-block;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .wash-drum { border: 3px solid rgba(34, 197, 94, .4); border-radius: 50%; animation: drumSpin 3s linear infinite; }
    @keyframes drumSpin { to { transform: rotate(360deg); } }

    .stagger > * { opacity: 0; transform: translateY(20px); }
    .stagger.visible > *:nth-child(1) { animation: fadeUp .5s .1s forwards; }
    .stagger.visible > *:nth-child(2) { animation: fadeUp .5s .2s forwards; }
    .stagger.visible > *:nth-child(3) { animation: fadeUp .5s .3s forwards; }
    .stagger.visible > *:nth-child(4) { animation: fadeUp .5s .4s forwards; }
    .stagger.visible > *:nth-child(5) { animation: fadeUp .5s .5s forwards; }
    .stagger.visible > *:nth-child(6) { animation: fadeUp .5s .6s forwards; }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }

    @keyframes pricePulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.08); } }
    .price-pulse { animation: pricePulse .3s ease; }

    .nav-glass { background: rgba(10, 15, 13, .8); backdrop-filter: blur(20px); border-bottom: 1px solid var(--border); }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(34, 197, 94, .3); border-radius: 3px; }

    @media (max-width: 768px) { .desktop-only { display: none; } }
</style>

</head>

<body>

<!-- ==================== NAVIGATION ==================== -->

<nav class="nav-glass fixed top-0 left-0 w-full z-50 transition-all duration-300" id="mainNav">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-brand-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-tshirt text-white text-lg"></i>
            </div>
            <span class="font-display text-xl text-brand-200">LaundryPOS</span>
        </a>

        <div class="flex items-center gap-4">

            @auth
                <a href="{{ route('pos.dashboard') }}" class="text-sm text-brand-400 hover:text-brand-200 transition-colors flex items-center gap-2">
                    <i class="fas fa-gauge text-xs"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-brand-400 hover:text-brand-200 transition-colors flex items-center gap-2">
                    <i class="fas fa-lock text-xs"></i> Admin Login
                </a>
            @endauth

            <button onclick="showPage('order')" class="glow-btn px-5 py-2.5 rounded-xl text-white font-semibold text-sm">
                Make an Order
            </button>

        </div>
    </div>
</nav>

<!-- ==================== TOAST ==================== -->

<div class="toast" id="toast">
    <div class="flex items-center gap-3">
        <i class="fas fa-check-circle text-brand-400"></i>
        <span id="toastMsg"></span>
    </div>
</div>

<!-- ==================== LANDING PAGE ==================== -->

<div class="page active" id="page-landing">

<section class="relative min-h-screen flex items-center overflow-hidden">

    <div class="blob w-96 h-96 bg-brand-500 top-20 -left-40"></div>
    <div class="blob w-80 h-80 bg-brand-400 top-1/3 right-0" style="animation-delay:3s"></div>
    <div class="blob w-64 h-64 bg-yellow-400 bottom-20 left-1/3" style="animation-delay:6s"></div>
    <div id="heroParticles" class="absolute inset-0 overflow-hidden pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 pt-24 pb-16 relative z-10 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <div class="stagger" id="heroContent">

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-brand-600/30 bg-brand-900/40 text-brand-300 text-sm mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span>
                    Now serving your area
                </div>

                <h1 class="font-display text-5xl md:text-7xl leading-tight mb-6">
                    Fresh clothes,
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 via-yellow-300 to-brand-300">
                        zero effort.
                    </span>
                </h1>

                <p class="text-lg text-brand-200/70 leading-relaxed mb-8 max-w-lg">
                    Premium laundry and dry cleaning delivered to your door.
                    Schedule a pickup, we handle the rest.
                </p>

                <div class="flex flex-wrap gap-4">
                    <button onclick="showPage('order')" class="glow-btn px-8 py-4 rounded-2xl text-white font-bold text-lg flex items-center gap-3">
                        Make an Order <i class="fas fa-arrow-right"></i>
                    </button>
                    <button onclick="document.getElementById('howItWorks').scrollIntoView({behavior:'smooth'})" class="px-8 py-4 rounded-2xl border border-brand-600/30 text-brand-300 font-semibold hover:bg-brand-900/40 transition-all flex items-center gap-3">
                        <i class="fas fa-play-circle"></i> How it works
                    </button>
                </div>

                <div class="flex items-center gap-8 mt-10 text-sm text-brand-300/60">
                    <div class="flex items-center gap-2"><i class="fas fa-clock text-brand-500"></i> 24hr turnaround</div>
                    <div class="flex items-center gap-2"><i class="fas fa-truck text-brand-500"></i> Free pickup</div>
                    <div class="flex items-center gap-2"><i class="fas fa-shield-alt text-brand-500"></i> Insured</div>
                </div>

            </div>

            <div class="relative flex items-center justify-center">
                <div class="relative w-80 h-80 md:w-96 md:h-96">
                    <div class="absolute inset-0 rounded-full border-2 border-brand-600/20 animate-pulse"></div>
                    <div class="absolute inset-8 rounded-full bg-gradient-to-br from-brand-900/60 to-brand-800/30 border border-brand-600/20 flex items-center justify-center overflow-hidden">
                        <div class="wash-drum w-48 h-48 md:w-56 md:h-56 flex items-center justify-center">
                            <div class="w-40 h-40 md:w-48 md:h-48 rounded-full border border-dashed border-brand-500/20 flex items-center justify-center">
                                <i class="fas fa-tshirt text-brand-400/60 text-5xl animate-bounce" style="animation-duration:2s"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section id="howItWorks" class="py-24 relative">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16 reveal">
            <h2 class="font-display text-4xl md:text-5xl mb-4">How it works</h2>
            <p class="text-brand-200/50 text-lg max-w-xl mx-auto">Four simple steps to fresh, clean clothes</p>
        </div>

        <div class="grid md:grid-cols-4 gap-8 stagger" id="stepsGrid">
            <div class="text-center group">
                <div class="w-20 h-20 rounded-2xl bg-brand-900/50 border border-brand-600/20 flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-all">
                    <i class="fas fa-list-check text-brand-400 text-2xl"></i>
                </div>
                <div class="text-brand-500 font-bold text-sm mb-2">Step 1</div>
                <h3 class="font-semibold text-lg mb-2">Choose Services</h3>
                <p class="text-brand-200/40 text-sm">Pick from our laundry options</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 rounded-2xl bg-brand-900/50 border border-brand-600/20 flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-all">
                    <i class="fas fa-calendar-check text-brand-400 text-2xl"></i>
                </div>
                <div class="text-brand-500 font-bold text-sm mb-2">Step 2</div>
                <h3 class="font-semibold text-lg mb-2">Schedule Pickup</h3>
                <p class="text-brand-200/40 text-sm">Select date, time, and location</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 rounded-2xl bg-brand-900/50 border border-brand-600/20 flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-all">
                    <i class="fas fa-hand-sparkles text-brand-400 text-2xl"></i>
                </div>
                <div class="text-brand-500 font-bold text-sm mb-2">Step 3</div>
                <h3 class="font-semibold text-lg mb-2">We Clean</h3>
                <p class="text-brand-200/40 text-sm">Professionally cleaned and pressed</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 rounded-2xl bg-brand-900/50 border border-brand-600/20 flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-all">
                    <i class="fas fa-box-open text-brand-400 text-2xl"></i>
                </div>
                <div class="text-brand-500 font-bold text-sm mb-2">Step 4</div>
                <h3 class="font-semibold text-lg mb-2">Delivered Fresh</h3>
                <p class="text-brand-200/40 text-sm">Right to your doorstep</p>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section class="py-24 relative">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16 reveal">
            <h2 class="font-display text-4xl md:text-5xl mb-4">Our Services</h2>
            <p class="text-brand-200/50 text-lg max-w-xl mx-auto">Professional care for every fabric</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 stagger" id="servicesPreview"></div>

        <div class="text-center mt-12 reveal">
            <button onclick="showPage('order')" class="glow-btn px-8 py-4 rounded-2xl text-white font-bold text-lg">
                View All & Order
            </button>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="border-t border-brand-800/30 py-12 mt-12">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center">
                <i class="fas fa-tshirt text-white text-sm"></i>
            </div>
            <span class="font-display text-lg text-brand-300">LaundryPOS</span>
        </div>
        <p class="text-brand-200/30 text-sm">Premium laundry service. Fresh clothes, zero effort.</p>
    </div>
</footer>

</div>

<!-- ==================== ORDER PAGE ==================== -->

<div class="page" id="page-order">
<section class="min-h-screen pt-28 pb-16 relative">
    <div class="blob w-72 h-72 bg-brand-500 top-40 -right-20"></div>

    <div class="max-w-5xl mx-auto px-6 relative z-10">

        <div class="mb-10">
            <button onclick="showPage('landing')" class="text-brand-400 hover:text-brand-200 text-sm mb-4 inline-flex items-center gap-2 transition-colors">
                <i class="fas fa-arrow-left"></i> Back to Home
            </button>
            <h1 class="font-display text-4xl md:text-5xl mb-2">Select Your Services</h1>
            <p class="text-brand-200/50">Choose services and set quantities. Total updates automatically.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-5 mb-8" id="orderServicesGrid"></div>

        <div class="sticky bottom-0 z-20 mt-8">
            <div class="rounded-2xl border border-brand-600/30 bg-brand-900/80 backdrop-blur-xl p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">

                    <div>
                        <div class="text-sm text-brand-300/50 mb-1">Selected</div>
                        <div class="font-semibold text-lg" id="cartSummaryText">No services selected</div>
                    </div>

                    <div class="text-right">
                        <div class="text-sm text-brand-300/50 mb-1">Total</div>
                        <div class="font-display text-3xl text-brand-400" id="cartTotal">Ksh 0.00</div>
                    </div>

                    <button onclick="goToCheckout()" class="glow-btn px-8 py-3.5 rounded-xl text-white font-bold flex items-center gap-3" id="checkoutBtn" disabled style="opacity:.4">
                        Proceed to Checkout <i class="fas fa-arrow-right"></i>
                    </button>

                </div>
            </div>
        </div>

    </div>
</section>
</div>

<!-- ==================== CHECKOUT PAGE ==================== -->

<div class="page" id="page-checkout">
<section class="min-h-screen pt-28 pb-16 relative">
    <div class="max-w-3xl mx-auto px-6 relative z-10">

        <button onclick="showPage('order')" class="text-brand-400 hover:text-brand-200 text-sm mb-4 inline-flex items-center gap-2 transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Services
        </button>

        <h1 class="font-display text-4xl md:text-5xl mb-2">Complete Your Order</h1>
        <p class="text-brand-200/50 mb-10">Fill in your details and schedule a pickup.</p>

        <div class="rounded-2xl border border-brand-600/20 bg-brand-900/40 p-6 mb-8">
            <h3 class="font-semibold text-brand-300 mb-4 flex items-center gap-2">
                <i class="fas fa-receipt text-brand-500"></i> Order Summary
            </h3>

            <div id="checkoutSummary" class="space-y-3"></div>

            <div class="border-t border-brand-600/20 mt-4 pt-4 flex justify-between items-center">
                <span class="font-semibold text-brand-200/70">Total</span>
                <span class="font-display text-2xl text-brand-400" id="checkoutTotal">Ksh 0.00</span>
            </div>
        </div>

        <form id="checkoutForm" onsubmit="submitOnlineOrder(event)" class="space-y-6">

            <h3 class="font-semibold text-xl flex items-center gap-2">
                <i class="fas fa-user-circle text-brand-500"></i> Your Details
            </h3>

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm text-brand-300/60 mb-2">Full Name</label>
                    <input type="text" name="customerName" class="form-input" placeholder="John Doe" required>
                </div>
                <div>
                    <label class="block text-sm text-brand-300/60 mb-2">Mobile Number</label>
                    <input type="tel" name="mobile" class="form-input" placeholder="+254 712 345 678" required>
                </div>
            </div>

            <div>
                <label class="block text-sm text-brand-300/60 mb-2">Pickup Location</label>
                <input type="text" name="location" class="form-input" placeholder="123 Main St, Westlands, Nairobi" required>
            </div>

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm text-brand-300/60 mb-2">Pickup Date</label>
                    <input type="date" name="pickupDate" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm text-brand-300/60 mb-2">Pickup Time</label>
                    <input type="time" name="pickupTime" class="form-input" required>
                </div>
            </div>

            <div>
                <label class="block text-sm text-brand-300/60 mb-2">Special Instructions</label>
                <textarea name="notes" class="form-input" rows="3" placeholder="Any special requests..."></textarea>
            </div>

            <button type="submit" class="glow-btn w-full px-8 py-4 rounded-2xl text-white font-bold text-lg flex items-center justify-center gap-3" id="submitOrderBtn">
                <i class="fas fa-paper-plane"></i> Submit Order
            </button>

        </form>

    </div>
</section>
</div>

<!-- ==================== CONFIRMATION ==================== -->

<div class="page" id="page-confirmation">
<section class="min-h-screen flex items-center justify-center pt-24 pb-16 relative">
    <div class="max-w-lg mx-auto px-6 text-center relative z-10">

        <div class="w-24 h-24 rounded-full bg-brand-500/20 border-2 border-brand-500 flex items-center justify-center mx-auto mb-8">
            <i class="fas fa-check text-brand-400 text-4xl"></i>
        </div>

        <h1 class="font-display text-4xl md:text-5xl mb-4">Order Placed</h1>
        <p class="text-brand-200/50 text-lg mb-3">Your laundry pickup has been scheduled.</p>
        <p class="text-brand-200/40 mb-8">
            Invoice: <span class="text-brand-400 font-mono font-bold" id="confirmOrderId"></span>
        </p>

        <div class="rounded-2xl border border-brand-600/20 bg-brand-900/40 p-6 text-left mb-8" id="confirmDetails"></div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="showPage('landing')" class="glow-btn px-6 py-3 rounded-xl text-white font-semibold flex items-center justify-center gap-2">
                <i class="fas fa-home"></i> Back to Home
            </button>
            <button onclick="showPage('order')" class="px-6 py-3 rounded-xl border border-brand-600/30 text-brand-300 font-semibold hover:bg-brand-900/40 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-plus"></i> New Order
            </button>
        </div>

    </div>
</section>
</div>

<script>

/* ==========================================================
   SERVICE DATA — now the real services from your database,
   injected by HomeController via $services. No more hardcoded array.
   ========================================================== */

let services = @json($servicesForJs);


/* ==========================================================
   CART
   ========================================================== */

let cart = {};


/* ==========================================================
   HELPERS
   ========================================================== */

function formatKsh(amount) {
    return 'Ksh ' + Number(amount).toLocaleString('en-KE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function formatTime(time) {
    if (!time) return '';
    const parts = time.split(':');
    let hour = parseInt(parts[0]);
    const minute = parts[1];
    const suffix = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12 || 12;
    return `${hour}:${minute} ${suffix}`;
}

function formatDate(date) {
    if (!date) return '';
    return new Date(date + 'T00:00:00').toLocaleDateString('en-KE', { month: 'short', day: 'numeric', year: 'numeric' });
}

function todayStr() {
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}


/* ==========================================================
   TOAST
   ========================================================== */

function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMsg');
    if (!toast || !toastMessage) return;
    toastMessage.textContent = message;
    toast.classList.add('show');
    clearTimeout(window.toastTimer);
    window.toastTimer = setTimeout(() => toast.classList.remove('show'), 3500);
}


/* ==========================================================
   PAGE NAVIGATION
   ========================================================== */

function showPage(pageId) {
    document.querySelectorAll('.page').forEach(page => page.classList.remove('active'));
    const page = document.getElementById('page-' + pageId);
    if (!page) return;

    setTimeout(() => {
        page.classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 50);

    if (pageId === 'order') renderOrderPage();
    if (pageId === 'checkout') renderCheckoutPage();
    if (pageId === 'landing') {
        renderLandingServices();
        setTimeout(() => initLandingAnimations(), 100);
    }
}


/* ==========================================================
   LANDING SERVICES
   ========================================================== */

function renderLandingServices() {
    const container = document.getElementById('servicesPreview');
    if (!container) return;

    if (services.length === 0) {
        container.innerHTML = '<p class="text-brand-200/40 col-span-full text-center">No services available yet.</p>';
        return;
    }

    container.innerHTML = services.slice(0, 3).map(service => `
        <div class="service-card rounded-2xl p-6 text-center group cursor-pointer" onclick="showPage('order')">
            <div class="w-16 h-16 rounded-xl overflow-hidden mx-auto mb-4">
                <img src="${service.image}" alt="${service.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            </div>
            <h3 class="font-semibold text-lg mb-1">${service.name}</h3>
            <div class="text-brand-400 font-display text-2xl mb-1">${formatKsh(service.price)}</div>
            <div class="text-brand-200/30 text-sm">per ${service.unit}</div>
        </div>
    `).join('');
}


/* ==========================================================
   LANDING ANIMATIONS
   ========================================================== */

function initLandingAnimations() {
    const hero = document.getElementById('heroContent');
    if (hero) setTimeout(() => hero.classList.add('visible'), 200);

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
    }, { threshold: .15 });

    document.querySelectorAll('.reveal, .stagger').forEach(element => observer.observe(element));

    createHeroParticles();
}


/* ==========================================================
   PARTICLES
   ========================================================== */

function createHeroParticles() {
    const container = document.getElementById('heroParticles');
    if (!container || container.children.length > 0) return;

    for (let i = 0; i < 20; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        const size = Math.random() * 4 + 2;
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


/* ==========================================================
   ORDER PAGE
   ========================================================== */

function renderOrderPage() {
    const container = document.getElementById('orderServicesGrid');
    if (!container) return;

    if (services.length === 0) {
        container.innerHTML = '<p class="text-brand-200/40 col-span-full text-center">No services available yet. Please check back soon.</p>';
        updateCartSummary();
        return;
    }

    container.innerHTML = services.map(service => {
        const quantity = cart[service.id] || 0;
        return `
            <div class="service-card rounded-2xl p-5 ${quantity > 0 ? 'selected' : ''}">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="${service.image}" alt="${service.name}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-lg mb-0.5">${service.name}</h3>
                        <div class="flex items-baseline gap-2 mb-3">
                            <span class="text-brand-400 font-display text-xl">${formatKsh(service.price)}</span>
                            <span class="text-brand-200/30 text-sm">/ ${service.unit}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" class="qty-btn" onclick="changeQty(${service.id}, -1)"><i class="fas fa-minus text-xs"></i></button>
                            <span class="font-bold text-lg w-8 text-center">${quantity}</span>
                            <button type="button" class="qty-btn" onclick="changeQty(${service.id}, 1)"><i class="fas fa-plus text-xs"></i></button>
                            <span class="text-brand-200/30 text-sm ml-2">${service.unit}${quantity !== 1 ? 's' : ''}</span>
                        </div>
                    </div>
                </div>
                ${quantity > 0 ? `
                    <div class="mt-3 pt-3 border-t border-brand-600/15 text-right">
                        <span class="text-brand-300/50 text-sm">Subtotal:</span>
                        <span class="text-brand-400 font-semibold">${formatKsh(service.price * quantity)}</span>
                    </div>
                ` : ''}
            </div>
        `;
    }).join('');

    updateCartSummary();
}


/* ==========================================================
   CHANGE QUANTITY
   ========================================================== */

function changeQty(id, difference) {
    if (!cart[id]) cart[id] = 0;
    cart[id] = Math.max(0, cart[id] + difference);
    if (cart[id] === 0) delete cart[id];
    renderOrderPage();
}


/* ==========================================================
   CART TOTAL
   ========================================================== */

function getCartTotal() {
    return Object.keys(cart).reduce((total, id) => {
        const service = services.find(item => item.id === parseInt(id));
        if (!service) return total;
        return total + service.price * cart[id];
    }, 0);
}

function updateCartSummary() {
    const selected = Object.keys(cart).filter(id => cart[id] > 0);
    const total = getCartTotal();
    const summary = document.getElementById('cartSummaryText');
    const totalElement = document.getElementById('cartTotal');
    const checkoutButton = document.getElementById('checkoutBtn');

    if (!summary || !totalElement || !checkoutButton) return;

    if (selected.length === 0) {
        summary.textContent = 'No services selected';
        totalElement.textContent = 'Ksh 0.00';
        checkoutButton.disabled = true;
        checkoutButton.style.opacity = '.4';
        return;
    }

    summary.textContent = selected.length + ' service' + (selected.length > 1 ? 's' : '') + ' selected';
    totalElement.textContent = formatKsh(total);
    checkoutButton.disabled = false;
    checkoutButton.style.opacity = '1';

    totalElement.classList.add('price-pulse');
    setTimeout(() => totalElement.classList.remove('price-pulse'), 300);
}


/* ==========================================================
   CHECKOUT
   ========================================================== */

function goToCheckout() {
    const selected = Object.keys(cart).filter(id => cart[id] > 0);
    if (selected.length === 0) {
        showToast('Please select at least one service');
        return;
    }
    showPage('checkout');
}


/* ==========================================================
   CHECKOUT SUMMARY
   ========================================================== */

function renderCheckoutPage() {
    const summary = document.getElementById('checkoutSummary');
    const totalElement = document.getElementById('checkoutTotal');
    if (!summary || !totalElement) return;

    let total = 0;
    let html = '';

    Object.keys(cart).forEach(id => {
        const service = services.find(item => item.id === parseInt(id));
        if (!service) return;
        const subtotal = service.price * cart[id];
        total += subtotal;
        html += `
            <div class="flex justify-between items-center">
                <div>
                    <span class="font-medium">${service.name}</span>
                    <span class="text-brand-200/30 text-sm ml-2">x${cart[id]} ${service.unit}${cart[id] > 1 ? 's' : ''}</span>
                </div>
                <span class="text-brand-300 font-semibold">${formatKsh(subtotal)}</span>
            </div>
        `;
    });

    summary.innerHTML = html || '<p class="text-brand-200/40">No services selected.</p>';
    totalElement.textContent = formatKsh(total);

    const dateInput = document.querySelector('input[name="pickupDate"]');
    if (dateInput) dateInput.min = todayStr();
}


/* ==========================================================
   SUBMIT ONLINE ORDER — posts to the PUBLIC route, no auth needed
   ========================================================== */

function submitOnlineOrder(event) {
    event.preventDefault();

    const form = event.target;
    const button = document.getElementById('submitOrderBtn');
    const selected = Object.keys(cart).filter(id => cart[id] > 0);

    if (selected.length === 0) {
        showToast('Your cart is empty');
        return;
    }

    const orderData = {
        customer_name: form.customerName.value.trim(),
        phone:         form.mobile.value.trim(),
        location:      form.location.value.trim(),
        pickup_date:   form.pickupDate.value,
        pickup_time:   form.pickupTime.value,
        notes:         form.notes.value.trim(),
        services: selected.map(id => {
            const service = services.find(item => item.id === parseInt(id));
            return { id: service.id, quantity: cart[id] };
        }),
    };

    button.disabled = true;
    button.innerHTML = '<span class="spinner"></span> Submitting...';

    fetch('{{ route('online-orders.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(orderData)
    })
    .then(async response => {
        const data = await response.json();
        if (!response.ok) {
            // Laravel validation errors come back as data.errors: an object of arrays
            const firstError = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Unable to submit your order.');
            throw new Error(firstError);
        }
        return data;
    })
    .then(data => {
        button.disabled = false;
        button.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Order';

        form.reset();
        cart = {};

        showConfirmation({
            invoice_number: data.order.order_number,
            customer_name: data.order.customer_name,
            mobile: data.order.phone,
            location: data.order.delivery_address,
            pickup_date: data.order.pickup_date,
            pickup_time: data.order.pickup_time,
            total: data.order.total_amount,
        });
    })
    .catch(error => {
        console.error('Order submission error:', error);
        button.disabled = false;
        button.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Order';
        showToast(error.message || 'Something went wrong while submitting your order.');
    });
}


/* ==========================================================
   CONFIRMATION
   ========================================================== */

function showConfirmation(order) {
    const invoice = order.invoice_number || order.id || 'Pending';
    const customerName = order.customer_name || 'Customer';
    const mobile = order.mobile || '—';
    const location = order.location || '—';
    const pickupDate = order.pickup_date || '';
    const pickupTime = order.pickup_time || '';
    const total = Number(order.total || 0);

    document.getElementById('confirmOrderId').textContent = invoice;

    document.getElementById('confirmDetails').innerHTML = `
        <div class="space-y-3 text-sm">
            <div class="flex justify-between gap-4">
                <span class="text-brand-200/40">Name</span>
                <span class="font-medium text-right">${escapeHtml(customerName)}</span>
            </div>
            <div class="flex justify-between gap-4">
                <span class="text-brand-200/40">Mobile</span>
                <span class="font-medium text-right">${escapeHtml(mobile)}</span>
            </div>
            <div class="flex justify-between gap-4">
                <span class="text-brand-200/40">Location</span>
                <span class="font-medium text-right">${escapeHtml(location)}</span>
            </div>
            <div class="flex justify-between gap-4">
                <span class="text-brand-200/40">Pickup</span>
                <span class="font-medium text-right">${formatDate(pickupDate)}${pickupTime ? ' at ' + formatTime(pickupTime) : ''}</span>
            </div>
            <div class="border-t border-brand-600/15 pt-3 flex justify-between">
                <span class="text-brand-200/40">Total</span>
                <span class="font-display text-xl text-brand-400">${formatKsh(total)}</span>
            </div>
        </div>
    `;

    showPage('confirmation');
}


/* ==========================================================
   BASIC HTML ESCAPING
   ========================================================== */

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}


/* ==========================================================
   INITIALIZATION
   ========================================================== */

document.addEventListener('DOMContentLoaded', function () {
    renderLandingServices();
    setTimeout(initLandingAnimations, 100);

    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', function () {
        if (!nav) return;
        nav.style.background = window.scrollY > 50 ? 'rgba(10,15,13,.95)' : 'rgba(10,15,13,.8)';
    });

    const pickupDate = document.querySelector('input[name="pickupDate"]');
    if (pickupDate) pickupDate.min = todayStr();
});

</script>

</body>
</html>