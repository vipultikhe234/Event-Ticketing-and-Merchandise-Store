<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DiscountCodeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('login_user', [UserController::class, 'loginUser']);
// Route::post('register_user', [UserController::class, 'registerUser']);

// Route::group(['middleware' => 'auth:api'], function () {
//     Route::get('me', [UserController::class, 'me']);
//     Route::post('logout', [UserController::class, 'logout']);
//     Route::post('refresh', [UserController::class, 'refresh']);
// });

Route::controller(EventController::class)->group(function () {
    Route::post('/register_performer', 'registerPerformer');
    Route::post('/register_event', 'registerEvent');
    Route::get('/get_performer', 'getEventWithPerformer');
});

// RESTful API for Events
Route::get('/api-events', [EventController::class, 'apiIndex']);
Route::get('/api-events/{event}', [EventController::class, 'apiShow']);

// Merchandise API
Route::get('/merchandise', [MerchandiseController::class, 'index']);
Route::get('/merchandise/{id}', [MerchandiseController::class, 'show']);

Route::post('/check_coupon', [DiscountCodeController::class, 'checkCoupon']);
Route::post('/insert_coupon', [DiscountCodeController::class, 'createDiscountCode']);
Route::post('/book-event', [CheckoutController::class, 'bookEvent']);
Route::get('/booking/success', [CheckoutController::class, 'paymentSuccess']);
Route::get('/booking/cancel', [CheckoutController::class, 'paymentCancel']);
