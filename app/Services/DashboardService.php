<?php

namespace App\Services;

use Carbon\Carbon;
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
                self::amount("sales", __("words.sale"), __("words.today")),
                self::amount(
                    "purchases",
                    __("words.purchase"),
                    __("words.today")
                ),
                self::amount(
                    "products",
                    __("words.product"),
                    __("words.today")
                ),
                self::amount(
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
            "description" => __("words.period", [
                "number" => now()->translatedFormat("Y"),
            ]),
            "data" => [
                __("words.sale") => self::amountStatistic("sales"),
                __("words.purchase") => self::amountStatistic("purchases"),
            ],
        ];
    }

    public static function salePriceStatistic()
    {
        return [
            "title" => __("words.sale"),
            "data" => self::priceStatistic("sale_details"),
        ];
    }

    public static function purchasePriceStatistic()
    {
        return [
            "title" => __("words.purchase"),
            "data" => self::priceStatistic("purchase_details"),
        ];
    }

    public static function amount(
        string $table,
        string $title,
        string $description
    ) {
        return DB::table($table)
            ->selectRaw(
                "COUNT(*) AS amount, (
                 SELECT
                    COUNT(*)
                 FROM
                    $table
                 WHERE
                    DATE(created_at) = CURDATE()) AS amountToday"
            )
            ->get()
            ->transform(
                fn($table) => [
                    "title" => $title,
                    "amount" => $table->amount,
                    "amountToday" => $table->amountToday,
                    "amountTodayDescription" => $description,
                ]
            )
            ->first();
    }

    public static function amountStatistic(string $table)
    {
        return DB::table($table)
            ->selectRaw(
                "COUNT(*) AS amount,
                 DATE_FORMAT(created_at, '%b') AS month"
            )
            ->whereRaw("YEAR(created_at) = YEAR(CURDATE())")
            ->groupByRaw("month")
            ->orderByRaw("created_at")
            ->get()
            ->pluck("amount", "month");
    }

    public static function priceStatistic(string $table)
    {
        return DB::table($table)
            ->selectRaw(
                "price,
                 created_at"
            )
            ->orderByRaw("created_at")
            ->get()
            ->groupBy([
                fn($value) => Carbon::parse($value->created_at)->format("Y"),
                fn($value) => Carbon::parse($value->created_at)->format("M"),
            ])
            ->take(2)
            ->transform(
                fn($year) => $year->transform(
                    fn($month) => $month->sum(fn($arr) => $arr->price)
                )
            );
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
