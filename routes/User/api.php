<?php

use App\Http\Controllers\MonnifyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\User\AuthController;
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
    Route::get('/delete-account', [AuthController::class, 'deleteAccount'])->name('delete-account');

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

});
