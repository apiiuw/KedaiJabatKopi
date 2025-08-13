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
use App\Http\Controllers\Owner\ODashboardController;
use App\Http\Controllers\Owner\DailysExpenseController;
use App\Http\Controllers\Owner\ExpenseRecordsController;
use App\Http\Controllers\Owner\ManageCategoryExpenseController;
use App\Http\Controllers\Owner\ReportController;
use App\Http\Controllers\Owner\AccessControlController;
use App\Http\Controllers\Owner\OrderRecordsController;
use App\Http\Controllers\Owner\StoreOperationalController;

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
    // Dashboard Cashier
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
});

// ROLE OWNER
Route::middleware('role:owner')->group(function () {
    // Dashboard Owner
    Route::get('/owner/dashboard', [ODashboardController::class, 'index'])->name('owner.dashboard');

    // Daily's Expense
    Route::get('/owner/dailys-expense', [DailysExpenseController::class, 'index'])->name('owner.dailys-expense');
    Route::get('/owner/dailys-expense/add-expense', [DailysExpenseController::class, 'addExpense'])->name('owner.dailys-expense.add-expense');
    Route::post('/owner/dailys-expense/store', [DailysExpenseController::class, 'storeExpense'])->name('owner.dailys-expense.store');
    Route::get('/owner/dailys-expense/get-items', [DailysExpenseController::class, 'getItemsByCategory'])->name('owner.dailys-expense.get-items');
    Route::get('/owner/dailys-expense/get-price', [DailysExpenseController::class, 'getPriceByCategoryAndItem'])->name('owner.dailys-expense.get-price');
    Route::get('/owner/dailys-expense/edit/{id}', [DailysExpenseController::class, 'edit'])->name('owner.dailys-expense.edit');
    Route::put('/owner/dailys-expense/{id}', [DailysExpenseController::class, 'update'])->name('owner.dailys-expense.update');

    // Expense Records
    Route::get('/owner/expense-records', [ExpenseRecordsController::class, 'index'])->name('owner.expense-records');

    // Manage Category Expense
    Route::get('/owner/manage-category-expense', [ManageCategoryExpenseController::class, 'index'])->name('owner.manage-category-expense');
    Route::get('/owner/manage-category-expense/add-category', [ManageCategoryExpenseController::class, 'addCategory'])->name('owner.manage-category-expense.add-category');
    Route::post('/owner/manage-category-expense/add-category/store', [ManageCategoryExpenseController::class, 'storeCategory'])->name('owner.manage-category-expense.store');
    Route::get('/owner/manage-category-expense/edit/{id}', [ManageCategoryExpenseController::class, 'edit'])->name('owner.manage-category-expense.edit');
    Route::put('/owner/manage-category-expense/{id}', [ManageCategoryExpenseController::class, 'update'])->name('owner.manage-category-expense.update');

    // Past Order
    Route::get('/owner/order-records', [OrderRecordsController::class, 'index'])->name('owner.order-records');

    // Report
    Route::get('/owner/report', [ReportController::class, 'index'])->name('owner.report');
    Route::get('/owner/report/export-pdf', [ReportController::class, 'exportPdf'])->name('owner.report.export-pdf');

    // Access Control
    Route::get('/owner/access-control', [AccessControlController::class, 'index'])->name('owner.access-control');
    Route::get('/owner/access-control/add-account', [AccessControlController::class, 'addAccount'])->name('owner.access-control.add-account');
    Route::post('/owner/access-control/add-account/store', [AccessControlController::class, 'storeAccount'])->name('owner.access-control.add-account.store');
    Route::get('/owner/access-control/edit/{id}', [AccessControlController::class, 'edit'])->name('owner.access-control.edit');
    Route::put('/owner/access-control/{id}', [AccessControlController::class, 'update'])->name('owner.access-control.update');
    Route::delete('/owner/manage-category-expense/{id}', [ManageCategoryExpenseController::class, 'destroy'])->name('owner.manage-category-expense.destroy');

    // Store Operational Schedule
    Route::get('/owner/store-operational-schedule', [StoreOperationalController::class, 'index'])->name('owner.store-operational-schedule');
    Route::put('/owner/store-operational-schedule', [StoreOperationalController::class, 'updateSchedule'])->name('owner.store-operational-schedule.update');
    Route::post('/owner/store-operational-schedule/status', [StoreOperationalController::class, 'updateStatus'])->name('owner.store-operational-schedule.status');

});
