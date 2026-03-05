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
Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');

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
