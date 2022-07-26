<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\QueryService;
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
        // dd(QueryService::statisticDualYear("purchase_details", "purchases"));

        return inertia("Dashboards/Index", [
            "productAmount" => DashboardService::productAmount(),
            "productFavorites" => DashboardService::productFavorites(),
            "salePurchaseStatistic" => DashboardService::salePurchaseStatistic(),
        ]);
    }
}
