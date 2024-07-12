<?php

use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CableController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\MonnifyController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/create-account', [PaystackController::class, 'createdAccount']);
Route::post('/webhook/paystack', [PaystackController::class, 'handle']);
Route::post('/webhook/monnify', [MonnifyController::class, 'handle']);
Route::get('/appservices', [ServiceController::class, 'list'])->name('list-service');
Route::get('/balance', [ServiceController::class, 'balance'])->name('ballance');
Route::get('/activate-products/{id}', [ProductController::class, 'activateProduct'])->name('products.activate');
Route::get('/deactivate-products/{id}', [ProductController::class, 'deactivateProduct'])->name('products.deactivate');

Route::post('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');
Route::post('/verify',  [AuthController::class, 'verify'])->name('user.verify');
Route::post('/password-reset', [AuthController::class, 'createPasswordReset'])->name('password-reset');
Route::post('/complete-password-reset', [AuthController::class, 'completeResetPassword'])->name('complete-password-reset');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('log-out');
    Route::post('/delete-account', [AuthController::class, 'deleteAccount'])->name('delete-account');

    Route::get('/wallet', [AuthController::class, 'wallet'])->name('wallet-ballance');
    Route::get('/account-details', [AuthController::class, 'accountdetails'])->name('account-details');

    Route::get('/my-orders', [OrderController::class, 'read'])->name('order.list');
    Route::post('/order', [OrderController::class, 'make'])->name('order');
    Route::get('/orders/{id}', [OrderController::class, 'getOrderById'])->name('order.getbyid');
    Route::get('/order-status/{id}', [OrderController::class, 'status'])->name('status');
    // Route::get('/order-multistatus', [OrderController::class, 'multistatus'])->name('multistatus');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/edit-profile', [AuthController::class, 'profileUpdate'])->name('profile.update');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::put('/update-profile-image', [AuthController::class, 'profileImage'])->name('profile.image');

    Route::get('/products', [ProductController::class, 'products'])->name('products.list');
    Route::get('/products/{id}', [ProductController::class, 'getProductById'])->name('products.getbyid');
    Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('products.delete');

    // VTU Routes
    Route::get('/get-data-plans/{id}', [DataController::class, 'getplan'])->name('data.plans');
    Route::get('/get-bill-plans/{id}', [BillController::class, 'getplan'])->name('bill.plans');
    Route::get('/get-cable-plans/{id}', [CableController::class, 'getplan'])->name('cable.plans');

    Route::get('/get-networks', [NetworkController::class, 'getNetwork'])->name('networks');
    Route::get('/get-bill', [BillController::class, 'getBills'])->name('bill');
    Route::get('/get-cable', [CableController::class, 'getCables'])->name('cables');

    Route::post('/buy-airtime', [AirtimeController::class, 'createVtpassAirtime'])->name('buy-airtime');
    Route::post('/buy-data', [DataController::class, 'createVtpassData'])->name('buy-data');
    Route::post('/buy-bill', [BillController::class, 'createVtpassBill'])->name('buy-bill');
    Route::post('/buy-cable', [CableController::class, 'createVtpassCable'])->name('buy-cable');
    Route::post('/validate', [BillController::class, 'validateId'])->name('validate');
    Route::post('/callback', [WebhookController::class, 'handleWebhook'])->name('callback');

});
