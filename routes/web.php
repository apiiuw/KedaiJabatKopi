<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Midtrans\PaymentController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\AboutUsController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\DetailItemController;
use App\Http\Controllers\Cashier\DashboardController;
use App\Http\Controllers\Cashier\OrderController;
use App\Http\Controllers\Cashier\PastOrderController;
use App\Http\Controllers\Cashier\ManageMenuController;
use App\Http\Controllers\Cashier\ReportController;

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

// AUTH
Route::get('/auth/sign-in', [AuthController::class, 'index'])->name('auth.sign-in');
Route::post('/auth/sign-in', [AuthController::class, 'signIn'])->name('auth.sign-in.post');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/auth/sign-out', [AuthController::class, 'signOut'])->name('auth.sign-out');

// ROLE CUSTOMER
Route::get('/', [HomeController::class, 'index'])->name('customer.home');
Route::get('/menu', [MenuController::class, 'index'])->name('customer.menu');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('customer.about-us');

Route::get('/detail-item/{id_menu}', [DetailItemController::class, 'index'])->name('customer.detail-item');
Route::post('/detail-item/{id_menu}/add-cart', [DetailItemController::class, 'addToCart'])->name('customer.detail-item.add-cart');

Route::get('/cart', [CartController::class, 'index'])->name('customer.cart');
Route::get('/cart/edit/{id}', [CartController::class, 'edit'])->name('customer.cart.edit');
Route::put('/cart/update/{id}', [CartController::class, 'updateForm'])->name('customer.cart.updateForm');
Route::delete('/cart/{id}/delete', [CartController::class, 'destroy'])->name('customer.cart.delete');
Route::put('/cart/update-qty/{id}', [CartController::class, 'updateQty'])->name('customer.cart.updateQty');

Route::post('/checkout', [PaymentController::class, 'checkout'])->name('customer.checkout');
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('customer.payment.success');


// ROLE CASHIER
Route::middleware('role:cashier')->group(function () {
    Route::get('/cashier/dashboard', [DashboardController::class, 'index'])->name('cashier.dashboard');

    // Today's Order
    Route::get('/cashier/order', [OrderController::class, 'index'])->name('cashier.order');
    Route::post('cashier/order/{id_order}/process', [OrderController::class, 'process'])->name('orders.process');

    // Past Order
    Route::get('/cashier/past-order', [PastOrderController::class, 'index'])->name('cashier.past-order');

    // Manage Menu
    Route::get('/cashier/manage-menu', [ManageMenuController::class, 'index'])->name('cashier.manage-menu');

    Route::get('/cashier/manage-menu/add-menu', [ManageMenuController::class, 'addMenu'])->name('cashier.manage-menu.add');
    Route::post('/cashier/manage-menu/add-menu/store', [ManageMenuController::class, 'store'])->name('cashier.manage-menu.store');

    Route::get('/cashier/manage-menu/edit-menu/{id_menu}', [ManageMenuController::class, 'editMenu'])->name('cashier.manage-menu.edit');
    Route::put('/cashier/manage-menu/edit-menu/{id_menu}/update', [ManageMenuController::class, 'update'])->name('cashier.manage-menu.update');

    // Report
    Route::get('/cashier/report', [ReportController::class, 'index'])->name('cashier.report');
});

// ROLE OWNER
Route::middleware('role:owner')->group(function () {
    // Contoh:
    // Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
});
