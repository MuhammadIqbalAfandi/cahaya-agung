<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
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
        // DashboardService::dump();

        return inertia("Dashboards/Index", [
            "productAmount" => DashboardService::productAmount(),
            "productBestSelling" => DashboardService::productBestSelling(),
            "salePurchaseAmountStatistic" => DashboardService::salePurchaseAmountStatistic(),
            "salePriceStatistic" => DashboardService::salePriceStatistic(),
            "purchasePriceStatistic" => DashboardService::purchasePriceStatistic(),
        ]);
    }
}
