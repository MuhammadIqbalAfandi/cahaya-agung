<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public static function productBestSelling()
    {
        $query = DB::table("sale_details")
            ->selectRaw(
                "products.name AS title,
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

        return [
            "title" => __("words.best_product"),
            "data" => $query,
        ];
    }

    public static function productAmount()
    {
        return [
            "data" => [
                QueryService::amount(
                    "sales",
                    __("words.sale"),
                    __("words.today")
                ),
                QueryService::amount(
                    "purchases",
                    __("words.purchase"),
                    __("words.today")
                ),
                QueryService::amount(
                    "products",
                    __("words.product"),
                    __("words.today")
                ),
                QueryService::amount(
                    "stock_products",
                    __("words.stock_product"),
                    __("words.today")
                ),
            ],
        ];
    }

    public static function salePurchaseAmountStatistic()
    {
        return [
            "title" => __("words.sale_and_purchase"),
            "data" => [
                __("words.sale") => QueryService::amountStatistic("sales"),
                __("words.purchase") => QueryService::amountStatistic(
                    "purchases"
                ),
            ],
        ];
    }

    public static function salePriceStatistic()
    {
        return [
            "title" => __("words.sale"),
            "data" => QueryService::priceStatistic("sale_details"),
        ];
    }

    public static function purchasePriceStatistic()
    {
        return [
            "title" => __("words.purchase"),
            "data" => QueryService::priceStatistic("purchase_details"),
        ];
    }

    public static function dump()
    {
        return dd(
            self::productAmount(),
            self::productBestSelling(),
            self::salePurchaseAmountStatistic(),
            self::salePriceStatistic(),
            self::purchasePriceStatistic()
        );
    }
}
