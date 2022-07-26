<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class QueryService
{
    public static function amount(string $table, string $title)
    {
        return DB::table($table)
            ->selectRaw(
                "COUNT(*) AS amount,
                 (SELECT COUNT(*) FROM products WHERE DATE(updated_at) = CURDATE()) AS amountToday"
            )
            ->get()
            ->transform(
                fn($sale) => [
                    "title" => $title,
                    "amount" => $sale->amount,
                    "amountToday" => $sale->amountToday,
                ]
            )
            ->first();
    }

    public static function statistic(string $table)
    {
        return DB::table($table)
            ->selectRaw(
                "COUNT(*) AS amount,
                 DATE_FORMAT(created_at, '%b') AS month"
            )
            ->groupByRaw("MONTH(created_at)")
            ->get()
            ->pluck("amount", "month");
    }

    public static function statisticDualYear(string $table, string $tableJoin)
    {
        return DB::table($table)
            ->selectRaw(
                "DATE_FORMAT($table.created_at, '%Y') AS year,
                 DATE_FORMAT($table.created_at, '%b') AS month,
                 IF(
                 $tableJoin.ppn,
                 $table.price + $table.price * ((
                 SELECT
                    ppn
                 FROM
                    ppns) / 100),
                 $table.price
                 ) AS price,
                 COUNT(*) AS total"
            )
            ->join(
                $tableJoin,
                "$tableJoin.number",
                "=",
                "$table.purchase_number"
            )
            ->groupByRaw(
                "YEAR($table.created_at),
                 MONTH($table.created_at),
                 year,
                 month,
                 price
                 DESC"
            )
            ->get();
    }
}
