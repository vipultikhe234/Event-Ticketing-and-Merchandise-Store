<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});
Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::view('/login', 'auth.login')->name('login');
});

Route::post('/register-user', [UserController::class, 'registerUser']);
Route::post('/login-user', [UserController::class, 'loginUser']);
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

Route::get('/success', function () {
    return "Payment Successful!";
})->name('payment.success');
// Dashboard (protected)
Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::get('/my-bookings', [\App\Http\Controllers\UserOrderController::class, 'index'])->middleware('auth')->name('my-bookings');

// AJAX: get performers
Route::get('/events/{id}/performers', [EventController::class, 'getEventWithPerformer']);

Route::post('/check-coupon', [DiscountCodeController::class, 'checkCoupon'])->name('check-coupon');

// Checkout route (for Stripe payment)
Route::post('/checkout/{event}', [CheckoutController::class, 'checkout'])->name('checkout')->middleware('auth');

// Success & Cancel routes
Route::get('/checkout/success/{order}', [CheckoutController::class, 'paymentSuccess'])->name('checkout.success')->middleware('auth');
Route::get('/checkout/cancel/{order}', [CheckoutController::class, 'cancel'])->name('checkout.cancel')->middleware('auth');

// Payment preview page
Route::get('/checkout/preview/{event}', [CheckoutController::class, 'preview'])->name('checkout.preview');
// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('performers', App\Http\Controllers\Admin\PerformerController::class);
    Route::resource('events', App\Http\Controllers\Admin\EventController::class);
    Route::resource('merchandise', App\Http\Controllers\Admin\MerchandiseController::class);
    Route::resource('discount-codes', App\Http\Controllers\Admin\DiscountCodeController::class);
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'destroy']);
    Route::put('orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only(['index', 'edit', 'update', 'destroy']);
});
