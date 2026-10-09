<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OnlineCustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| SmartWash / LaundryPOS
|
| Route structure:
| - Public landing page and online ordering
| - Guest authentication
| - Authenticated POS and administration
| - Walk-in order management
| - Online customer order management
| - Reports
| - Services
|
|--------------------------------------------------------------------------
*/


// ==========================================================================
// PUBLIC ROUTES
// ==========================================================================

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
|
| Loads the public SmartWash landing page and available services.
|
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| Online Customer Order Submission
|--------------------------------------------------------------------------
|
| Customers can submit an online laundry order without logging in.
| Throttling provides basic protection against repeated submissions.
|
*/

Route::post('/online-order', [OnlineCustomerController::class, 'store'])
    ->name('online-orders.store')
    ->middleware('throttle:10,1');


// ==========================================================================
// GUEST ROUTES
// ==========================================================================

Route::middleware('guest')->group(function () {

    // ======================================================================
    // LOGIN
    // ======================================================================

    /*
    |--------------------------------------------------------------------------
    | Login Page
    |--------------------------------------------------------------------------
    */

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');


    /*
    |--------------------------------------------------------------------------
    | Login Processing
    |--------------------------------------------------------------------------
    */

    Route::post('/login', function (Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {

            /*
            |--------------------------------------------------------------------------
            | Prevent Session Fixation
            |--------------------------------------------------------------------------
            */

            $request->session()->regenerate();


            /*
            |--------------------------------------------------------------------------
            | Redirect Authenticated User
            |--------------------------------------------------------------------------
            */

            return redirect()->route('pos.dashboard');
        }


        /*
        |--------------------------------------------------------------------------
        | Authentication Failed
        |--------------------------------------------------------------------------
        */

        return back()
            ->withErrors([
                'email' => 'The email or password is incorrect.',
            ])
            ->withInput(
                $request->only('email')
            );

    })->name('login.process');

});


// ==========================================================================
// AUTHENTICATED ROUTES
// ==========================================================================

Route::middleware('auth')->group(function () {

    // ======================================================================
    // SESSION KEEP-ALIVE
    // ======================================================================

    Route::get('/keep-alive', function (Request $request) {

        return response()->json([
            'success' => true,
            'message' => 'Session is active',
        ]);

    })->name('keep-alive');


    // ======================================================================
    // ADMIN DASHBOARD
    // ======================================================================

    Route::get('/dashboard', [POSController::class, 'dashboard'])
        ->name('pos.dashboard');


    // ======================================================================
    // POS TERMINAL
    // ======================================================================

    Route::get('/pos', [POSController::class, 'index'])
        ->name('pos.index');


    /*
    |--------------------------------------------------------------------------
    | Customer Search
    |--------------------------------------------------------------------------
    */

    Route::get('/search-customer', [POSController::class, 'searchCustomer'])
        ->name('pos.searchCustomer');


    /*
    |--------------------------------------------------------------------------
    | Store Walk-In POS Order
    |--------------------------------------------------------------------------
    */

    Route::post('/store-order', [POSController::class, 'storeOrder'])
        ->name('pos.store');


    /*
    |--------------------------------------------------------------------------
    | Receipt
    |--------------------------------------------------------------------------
    */

    Route::get('/receipt/{order}', [POSController::class, 'receipt'])
        ->name('pos.receipt');


    // ======================================================================
    // WALK-IN ORDER MANAGEMENT
    // ======================================================================

    /*
    |--------------------------------------------------------------------------
    | Orders List
    |--------------------------------------------------------------------------
    */

    Route::get('/orders', [POSController::class, 'orderList'])
        ->name('orders.index');


    /*
    |--------------------------------------------------------------------------
    | Download Orders / Sales Report
    |--------------------------------------------------------------------------
    */

    Route::get('/orders/download', [POSController::class, 'downloadReport'])
        ->name('orders.download');


    /*
    |--------------------------------------------------------------------------
    | Update Walk-In Order Status
    |--------------------------------------------------------------------------
    |
    | Uses PUT to remain compatible with the existing POSController method.
    |
    */

    Route::put(
        '/orders/{order}/status',
        [POSController::class, 'updateStatus']
    )->name('orders.updateStatus');


    // ======================================================================
    // ONLINE ORDERS
    // ======================================================================

    /*
    |--------------------------------------------------------------------------
    | Online Orders Dashboard
    |--------------------------------------------------------------------------
    |
    | Displays orders submitted through the public online-order form.
    |
    */

    Route::get(
        '/online-orders',
        [OnlineCustomerController::class, 'index']
    )->name('online-orders.index');


    /*
    |--------------------------------------------------------------------------
    | Online Order Details
    |--------------------------------------------------------------------------
    |
    | Displays the complete details of an individual online order.
    |
    */

    Route::get(
        '/online-orders/{order}',
        [OnlineCustomerController::class, 'show']
    )->name('online-orders.show');


    /*
    |--------------------------------------------------------------------------
    | Update Online Order Status
    |--------------------------------------------------------------------------
    |
    | Updates the laundry/order processing status.
    |
    | Example statuses:
    | - pending
    | - processing
    | - ready
    | - completed
    | - delivered
    | - cancelled
    |
    */

    Route::patch(
        '/online-orders/{order}/status',
        [OnlineCustomerController::class, 'updateStatus']
    )->name('online-orders.update-status');


    /*
    |--------------------------------------------------------------------------
    | Update Online Order Payment Status
    |--------------------------------------------------------------------------
    |
    | This route is used by the Payment Status dropdown on the Online Orders
    | page.
    |
    | Payment values:
    | - paid
    | - not_paid
    |
    | The dropdown sends an AJAX PATCH request to this route.
    |
    */

    Route::patch(
        '/online-orders/{order}/payment-status',
        [OnlineCustomerController::class, 'updatePaymentStatus']
    )->name('online-orders.payment-status.update');


    // ======================================================================
    // SALES REPORTS
    // ======================================================================

    /*
    |--------------------------------------------------------------------------
    | Monthly Sales Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/monthly-sales',
        [ReportController::class, 'monthlySales']
    )->name('sales.monthly');


    // ======================================================================
    // SERVICES
    // ======================================================================

    /*
    |--------------------------------------------------------------------------
    | Laundry Services Management
    |--------------------------------------------------------------------------
    |
    | Creates:
    | - services.index
    | - services.create
    | - services.store
    | - services.edit
    | - services.update
    | - services.destroy
    |
    | "show" is intentionally excluded.
    |
    */

    Route::resource(
        'services',
        ServiceController::class
    )->except(['show']);


    // ======================================================================
    // LOGOUT
    // ======================================================================

    Route::post('/logout', function (Request $request) {

        /*
        |--------------------------------------------------------------------------
        | Logout Current User
        |--------------------------------------------------------------------------
        */

        Auth::logout();


        /*
        |--------------------------------------------------------------------------
        | Destroy Authenticated Session
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();


        /*
        |--------------------------------------------------------------------------
        | Generate Fresh CSRF Token
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerateToken();


        /*
        |--------------------------------------------------------------------------
        | Return To Public Website
        |--------------------------------------------------------------------------
        */

        return redirect()->route('home');

    })->name('logout');

});