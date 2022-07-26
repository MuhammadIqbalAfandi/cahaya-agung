<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public static function productFavorites()
    {
        return DB::table("sale_details")
            ->selectRaw(
                "sale_details.product_number,
                 products.name AS title,
                 SUM(sale_details.qty) AS qty,
                 products.profit"
            )
            ->join(
                "products",
                "products.number",
                "=",
                "sale_details.product_number"
            )
            ->groupByRaw("product_number")
            ->orderByRaw("qty DESC")
            ->limit(5)
            ->get();
    }

    public static function productAmount()
    {
        return [
            QueryService::amount("sales", __("words.sale")),
            QueryService::amount("purchases", __("words.purchase")),
            QueryService::amount("products", __("words.product")),
            QueryService::amount("stock_products", __("words.stock_product")),
        ];
    }

    public static function salePurchaseStatistic()
    {
        return [
            __("words.sale") => QueryService::statistic("sales"),
            __("words.purchase") => QueryService::statistic("purchases"),
        ];
    }
}
