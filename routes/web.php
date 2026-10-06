<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OnlineOrderController;
use App\Http\Controllers\OnlineCustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// PUBLIC ROUTES
// ==========================================

// Landing Page — now loads real services from the database
Route::get('/', [HomeController::class, 'index'])->name('home');

// Customer submits an order from the landing page (no login required)
Route::post('/online-order', [OnlineCustomerController::class, 'store'])
    ->name('online-orders.store')
    ->middleware('throttle:10,1'); // basic spam protection


// ==========================================
// GUEST ROUTES
// ==========================================

Route::middleware('guest')->group(function () {

    // ==========================================
    // LOGIN PAGE
    // ==========================================

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');


    // ==========================================
    // LOGIN PROCESSING
    // ==========================================

    Route::post('/login', function (Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            // Prevent session fixation
            $request->session()->regenerate();

            // Always send admin to the main dashboard
            return redirect()->route('pos.dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'The email or password is incorrect.',
            ])
            ->withInput(
                $request->only('email')
            );

    })->name('login.process');

});


// ==========================================
// AUTHENTICATED ROUTES
// ==========================================

Route::middleware('auth')->group(function () {

    // ==========================================
    // SESSION KEEP-ALIVE
    // ==========================================

    Route::get('/keep-alive', function (Request $request) {

        return response()->json([
            'success' => true,
            'message' => 'Session is active',
        ]);

    })->name('keep-alive');


    // ==========================================
    // ADMIN DASHBOARD
    // ==========================================

    Route::get('/dashboard', [POSController::class, 'dashboard'])
        ->name('pos.dashboard');


    // ==========================================
    // POS TERMINAL
    // ==========================================

    Route::get('/pos', [POSController::class, 'index'])
        ->name('pos.index');

    Route::get('/search-customer', [POSController::class, 'searchCustomer'])
        ->name('pos.searchCustomer');

    Route::post('/store-order', [POSController::class, 'storeOrder'])
        ->name('pos.store');

    Route::get('/receipt/{order}', [POSController::class, 'receipt'])
        ->name('pos.receipt');


    // ==========================================
    // ORDER MANAGEMENT (walk-in orders, via OnlineOrderController as you have it)
    // ==========================================

    Route::get('/orders', [POSController::class, 'orderList'])
        ->name('orders.index');

    Route::get('/orders/download', [POSController::class, 'downloadReport'])
        ->name('orders.download');

    Route::put('/orders/{order}/status', [POSController::class, 'updateStatus'])
        ->name('orders.updateStatus');


    // ==========================================
    // ONLINE ORDERS (admin) — customers who booked online, via OnlineCustomerController
    // ==========================================

    Route::get('/online-orders', [OnlineCustomerController::class, 'index'])
        ->name('online-orders.index');

    Route::get('/online-orders/{order}', [OnlineCustomerController::class, 'show'])
        ->name('online-orders.show');

    Route::put('/online-orders/{order}/status', [OnlineCustomerController::class, 'updateStatus'])
        ->name('online-orders.updateStatus');


    // ==========================================
    // SALES REPORTS
    // ==========================================

    Route::get('/reports/monthly-sales', [ReportController::class, 'monthlySales'])
        ->name('sales.monthly');


    // ==========================================
    // SERVICES
    // ==========================================

    Route::resource('services', ServiceController::class)
        ->except(['show']);


    // ==========================================
    // LOGOUT
    // ==========================================

    Route::post('/logout', function (Request $request) {

        Auth::logout();

        // Destroy authenticated session
        $request->session()->invalidate();

        // Generate a fresh CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('home');

    })->name('logout');

    Route::get('/setup-admin', function() {
    \App\Models\User::firstOrCreate(
        ['email' => 'admin@smartwash.co.ke'],
        [
            'name' => 'System Admin', 
            'password' => \Illuminate\Support\Facades\Hash::make('admin4321!')
        ]
    );
    return 'Admin account created successfully!';
});

});