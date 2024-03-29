<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PpnController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SettingController;
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

Route::middleware(["auth", "verified", "checkBlocked"])->group(function () {
    Route::get("/", DashboardController::class);

    Route::get("/dashboards", DashboardController::class);

    Route::put("/users/reset-password/{user}", [
        UserController::class,
        "resetPassword",
    ])->name("users.reset-password");

    Route::delete("/users/block/{user}", [
        UserController::class,
        "block",
    ])->name("users.block");

    Route::post("/users/change-password/{user}", [
        UserController::class,
        "changePassword",
    ])->name("users.change-password");

    Route::resource("/users", UserController::class);

    Route::resource("/ppn", PpnController::class);

    Route::resource("/companies", CompanyController::class);

    Route::resource("/settings", SettingController::class);

    Route::get("/customers/history-purchase/excel", [
        CustomerController::class,
        "historyPurchaseExcel",
    ])->name("customers.history-purchase.excel");

    Route::get("/customers/history-purchase/{sale}", [
        CustomerController::class,
        "historyPurchase",
    ])->name("customers.history-purchases");

    Route::resource("/customers", CustomerController::class);

    Route::get("/purchases/pdf/invoice/{purchase}", [
        PurchaseController::class,
        "invoice",
    ])->name("purchases.pdf.invoice");

    Route::get("/purchases/pdf/do/{purchase}", [
        PurchaseController::class,
        "deliveryOrder",
    ])->name("purchases.pdf.do");

    Route::get("/purchases/report/excel", [
        PurchaseController::class,
        "reportExcel",
    ])->name("purchases.report.excel");

    Route::get("/purchases/report", [
        PurchaseController::class,
        "report",
    ])->name("purchases.report");

    Route::resource("/purchases", PurchaseController::class);

    Route::get("/sales/pdf/invoice/{sale}", [
        SalesController::class,
        "invoice",
    ])->name("sales.pdf.invoice");

    Route::get("/sales/pdf/do/{sale}", [
        SalesController::class,
        "deliveryOrder",
    ])->name("sales.pdf.do");

    Route::get("/sales/report/excel", [
        SalesController::class,
        "reportExcel",
    ])->name("sales.report.excel");

    Route::get("/sales/report", [SalesController::class, "report"])->name(
        "sales.report"
    );

    Route::resource("/sales", SalesController::class);

    Route::resource("/suppliers", SupplierController::class);

    Route::get("/stock-products/history/excel", [
        StockProductController::class,
        "historyExcel",
    ])->name("stock-products.history.excel");

    Route::get("/stock-products/history/{product}", [
        StockProductController::class,
        "history",
    ])->name("stock-products.history");

    Route::resource("/stock-products", StockProductController::class);

    Route::resource("/products", ProductController::class);
});

require __DIR__ . "/auth.php";
