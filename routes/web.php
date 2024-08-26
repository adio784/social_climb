<?php

use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CableController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('Auth/Login');
    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::get('/dashboard', [DasboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.editadmin');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // User views .............................................................................
    Route::get('/role', [UserController::class, 'index'])->name('roles');
    Route::get('/permission', [UserController::class, 'index'])->name('permissions');
    Route::get('/services', [UserController::class, 'index'])->name('services');
    Route::get('/settings/accounts', [UserController::class, 'index'])->name('account-settings');
    Route::get('/settings/supports', [UserController::class, 'index'])->name('support');
    Route::get('/settings/termscondition', [UserController::class, 'index'])->name('termscondition');
    Route::get('/settings/faq', [UserController::class, 'index'])->name('faq');
    Route::get('/admins', [UserController::class, 'index'])->name('admin');

    Route::get('/network/list', [UserController::class, 'index'])->name('network-list');
    Route::get('/network/change', [UserController::class, 'index'])->name('network-change');

    Route::get('/pricing/data', [DataController::class, 'index'])->name('data-pricing');
    Route::get('/pricing/create-data', [DataController::class, 'createData'])->name('create-data');
    Route::get('/pricing/data/{id}', [DataController::class, 'read']);
    Route::get('/data/delete/{id}', [DataController::class, 'delete']);

    Route::get('/pricing/airtime', [AirtimeController::class, 'index'])->name('airtime-pricing');
    Route::get('/pricing/create-airtime', [AirtimeController::class, 'createAirtime'])->name('create-airtime');
    Route::get('/pricing/airtime/{id}', [AirtimeController::class, 'read']);
    Route::get('/airtime/delete/{id}', [AirtimeController::class, 'delete']);

    Route::get('/pricing/bill', [BillController::class, 'index'])->name('bill-pricing');
    Route::get('/pricing/create-bill', [BillController::class, 'createBill'])->name('create-bill');
    Route::get('/pricing/bill/{id}', [BillController::class, 'read']);
    Route::get('/bill/delete/{id}', [BillController::class, 'delete']);

    Route::get('/pricing/cable', [CableController::class, 'index'])->name('cable-pricing');
    Route::get('/pricing/create-cable', [CableController::class, 'createCable'])->name('create-cable');
    Route::get('/cable/delete/{id}', [CableController::class, 'delete']);
    Route::get('/pricing/cable/{id}', [CableController::class, 'read']);

    Route::get('/pricing/products', [ProductController::class, 'index'])->name('socio-pricing');
    Route::get('/products/create-product', [ProductController::class, 'createProduct'])->name('create-product');
    Route::get('/pricing/products/{id}', [ProductController::class, 'read']);
    Route::get('/products/delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::get('/products/activate/{id}', [ProductController::class, 'activateProduct']);
    Route::get('/products/deactivate/{id}', [ProductController::class, 'deactivateProduct']);

    Route::get('/history/data', [DataController::class, 'histories'])->name('data-history');
    Route::get('/history/airtime', [AirtimeController::class, 'histories'])->name('airtime-history');
    Route::get('/history/bill', [BillController::class, 'histories'])->name('bill-history');
    Route::get('/history/cable', [CableController::class, 'histories'])->name('cable-history');
    Route::get('/history/funds', [PaymentController::class, 'histories'])->name('funds-history');
    Route::get('/history/orders', [OrderController::class, 'histories'])->name('orders');

    Route::get('/view-data-details/{id}', [DataController::class, 'dataDetails']);
    Route::get('/view-airtime-details/{id}', [AirtimeController::class, 'airtimeDetails']);
    Route::get('/view-bill-details/{id}', [BillController::class, 'billDetails']);
    Route::get('/view-cable-details/{id}', [CableController::class, 'cableDetails']);
    Route::get('/view-order-details/{id}', [OrderController::class, 'orderDetails']);

    Route::get('/users/list', [UserController::class, 'index'])->name('list-users');
    Route::get('/users/admins', [UserController::class, 'admin'])->name('list-admins');
    Route::get('/users/{id}', [UserController::class, 'getUser']);
    Route::get('/admin/permissions/{id}', [UserController::class, 'getUserPermissions']);
    Route::get('/users/history/{id}', [UserController::class, 'userHistory']);
    Route::get('/users/activate/{id}', [UserController::class, 'activate']);
    Route::get('/users/deactivate/{id}', [UserController::class, 'deactivate']);
    Route::get('/user/make-admin/{id}', [UserController::class, 'makeAdmin']);
    Route::get('/user/remove-admin/{id}', [UserController::class, 'removeAdmin']);
    Route::get('/services', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/service/activate/{id}', [ServiceController::class, 'activate']);
    Route::get('/service/dissable/{id}', [ServiceController::class, 'dissable']);

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/banner', [BannerController::class, 'index'])->name('banner.index');
    Route::get('/notice/delete/{id}', [NotificationController::class, 'delete']);
    Route::get('/notice/toggle/{id}', [NotificationController::class, 'toggle']);

    Route::get('/banner', [BannerController::class, 'index'])->name('notification.index');
    Route::get('/banner/delete/{id}', [BannerController::class, 'delete']);
    Route::get('/banner/toggle/{id}', [BannerController::class, 'toggle']);
    Route::get('/profile-visits', [DasboardController::class, 'getProfileVisits']);



    Route::post('/change_user_pass', [UserController::class, 'changeUserPassword'])->name('change_user_pass');
    Route::post('/fund_wallet', [UserController::class, 'fundWallet'])->name('fund_wallet');

    Route::post('/create_data', [DataController::class, 'create'])->name('create_data');
    Route::post('/edit_data', [DataController::class, 'edit'])->name('edit_data');

    Route::post('/create_airtime', [AirtimeController::class, 'create'])->name('create_airtime');
    Route::post('/edit_airtime', [AirtimeController::class, 'edit'])->name('edit_airtime');

    Route::post('/create_bill', [BillController::class, 'create'])->name('create_bill');
    Route::post('/edit_bill', [BillController::class, 'edit'])->name('edit_bill');

    Route::post('/create_cable', [CableController::class, 'create'])->name('create_cable');
    Route::post('/edit_cable', [CableController::class, 'edit'])->name('edit_cable');

    Route::post('/create_product', [ProductController::class, 'create'])->name('create_product');
    Route::post('/edit_product', [ProductController::class, 'updateProduct'])->name('edit_product');

    Route::post('/create_notice', [NotificationController::class, 'create'])->name('create_notice');
    Route::post('/edit_notice', [NotificationController::class, 'update'])->name('edit_notice');

    Route::post('/create_banner', [BannerController::class, 'create'])->name('create_banner');
    Route::post('/edit_banner', [BannerController::class, 'update'])->name('edit_banner');
    Route::post('/create-user-permission', [UserController::class, 'userPermissions'])->name('create-user-permisson');
});

require __DIR__ . '/auth.php';
