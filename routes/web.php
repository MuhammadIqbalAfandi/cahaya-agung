<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockProductController;
use App\Http\Controllers\SupplierController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', DashboardController::class);

    Route::get('/dashboards', DashboardController::class);

    Route::delete('/users/block/{user}', [UserController::class, 'block'])
        ->name('users.block');
    Route::post('/users/change-password/{user}', [UserController::class, 'changePassword'])
        ->name('users.change-password');
    Route::resource('/users', UserController::class);

    Route::resource('/customers', CustomerController::class);

    Route::resource('/purchases', PurchaseController::class);

    Route::resource('/sales', SalesController::class);

    Route::resource('/suppliers', SupplierController::class);

    Route::resource('/stock-products', StockProductController::class);
});

require __DIR__ . '/auth.php';
