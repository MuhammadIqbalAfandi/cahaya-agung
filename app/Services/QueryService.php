<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QueryService
{
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
                    products
                 WHERE
                    DATE(updated_at) = CURDATE()) AS amountToday"
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
}
