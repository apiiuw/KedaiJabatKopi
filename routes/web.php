<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignOutController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\AboutUsController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\DetailItemController;
use App\Http\Controllers\Cashier\DashboardController;

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
Route::get('/auth/sign-in', [SignInController::class, 'index'])->name('auth.sign-in');
Route::get('/auth/sign-out', [SignOutController::class, 'index'])->name('auth.sign-out');

// ROLE CUSTOMER
Route::get('/', [HomeController::class, 'index'])->name('customer.home');
Route::get('/menu', [MenuController::class, 'index'])->name('customer.menu');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('customer.about-us');
Route::get('/cart', [CartController::class, 'index'])->name('customer.cart');

Route::get('/detail-item', [DetailItemController::class, 'index'])->name('customer.detail-item');

// ROLE CASHIER
Route::get('/cashier/dashboard', [DashboardController::class, 'index'])->name('cashier.dashboard');

// ROLE OWNER
