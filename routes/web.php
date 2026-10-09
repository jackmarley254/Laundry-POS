
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OnlineCustomerController;

/*
|--------------------------------------------------------------------------
| SmartWash Web Routes
|--------------------------------------------------------------------------
|
| Public website and online ordering
| Guest authentication
| Combined dashboard
| Walk-in POS order management
| Online customer order management
| Sales reports and services
|
|--------------------------------------------------------------------------
*/


// ==========================================================================
// PUBLIC ROUTES
// ==========================================================================

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

// Public online laundry order submission.
Route::post('/online-order', [OnlineCustomerController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('online-orders.store');


// ==========================================================================
// GUEST AUTHENTICATION
// ==========================================================================

Route::middleware('guest')->group(function () {

    // Login page.
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // Process login.
    Route::post('/login', function (Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            // Regenerate session ID after successful authentication.
            $request->session()->regenerate();

            return redirect()->intended(
                route('pos.dashboard')
            );
        }

        return back()
            ->withErrors([
                'email' => 'The email or password is incorrect.',
            ])
            ->onlyInput('email');

    })->name('login.process');

});


// ==========================================================================
// AUTHENTICATED APPLICATION
// ==========================================================================

Route::middleware('auth')->group(function () {

    // ----------------------------------------------------------------------
    // SESSION KEEP-ALIVE
    // ----------------------------------------------------------------------

    Route::get('/keep-alive', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Session is active',
        ]);
    })->name('keep-alive');


    // ----------------------------------------------------------------------
    // MAIN DASHBOARD
    // ----------------------------------------------------------------------
    //
    // DashboardController aggregates data from:
    // 1. Walk-in POS orders (Order model)
    // 2. Online customer orders (OnlineOrder model)
    //
    // Create app/Http/Controllers/DashboardController.php before using
    // this route.
    //

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('pos.dashboard');


    // ----------------------------------------------------------------------
    // WALK-IN POS TERMINAL
    // ----------------------------------------------------------------------

    Route::get('/pos', [POSController::class, 'index'])
        ->name('pos.index');

    Route::get('/search-customer', [POSController::class, 'searchCustomer'])
        ->name('pos.searchCustomer');

    Route::post('/store-order', [POSController::class, 'storeOrder'])
        ->name('pos.store');

    Route::get('/receipt/{order}', [POSController::class, 'receipt'])
        ->name('pos.receipt');


    // ----------------------------------------------------------------------
    // WALK-IN ORDER MANAGEMENT
    // ----------------------------------------------------------------------

    Route::get('/orders', [POSController::class, 'orderList'])
        ->name('orders.index');

    // Keep the download route before other order-specific routes.
    Route::get('/orders/download', [POSController::class, 'downloadReport'])
        ->name('orders.download');

    Route::put('/orders/{order}/status', [POSController::class, 'updateStatus'])
        ->name('orders.updateStatus');


    // ----------------------------------------------------------------------
    // ONLINE CUSTOMER ORDER MANAGEMENT
    // ----------------------------------------------------------------------

    Route::get('/online-orders', [OnlineCustomerController::class, 'index'])
        ->name('online-orders.index');

    Route::get('/online-orders/{order}', [OnlineCustomerController::class, 'show'])
        ->name('online-orders.show');

    Route::patch(
        '/online-orders/{order}/status',
        [OnlineCustomerController::class, 'updateStatus']
    )->name('online-orders.update-status');

    Route::patch(
        '/online-orders/{order}/payment-status',
        [OnlineCustomerController::class, 'updatePaymentStatus']
    )->name('online-orders.payment-status.update');


    // ----------------------------------------------------------------------
    // SALES REPORTS
    // ----------------------------------------------------------------------

    Route::get(
        '/reports/monthly-sales',
        [ReportController::class, 'monthlySales']
    )->name('sales.monthly');


    // ----------------------------------------------------------------------
    // LAUNDRY SERVICES
    // ----------------------------------------------------------------------

    Route::resource('services', ServiceController::class)
        ->except(['show']);


    // ----------------------------------------------------------------------
    // LOGOUT
    // ----------------------------------------------------------------------

    Route::post('/logout', function (Request $request) {

        Auth::logout();

        // Invalidate the old session.
        $request->session()->invalidate();

        // Generate a new CSRF token.
        $request->session()->regenerateToken();

        return redirect()->route('home');

    })->name('logout');

});