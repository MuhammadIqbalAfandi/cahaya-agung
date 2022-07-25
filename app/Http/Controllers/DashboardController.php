<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\PurchaseService;
use App\Services\SaleService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return inertia("Dashboards/Index", [
            "productCounts" => [
                SaleService::saleAmount(),
                PurchaseService::purchaseAmount(),
                ProductService::productAmount(),
                ProductService::stockProductAmount(),
            ],
            "productFavorites" => SaleService::bestSelling(),
        ]);
    }
}
