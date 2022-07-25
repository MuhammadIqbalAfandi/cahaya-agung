<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class QueryService
{
    public static function queryAmount(string $table, string $title)
    {
        return DB::table($table)
            ->selectRaw(
                "COUNT(*) as amount,
                (SELECT COUNT(*) FROM products WHERE DATE(updated_at) = CURDATE()) as amountToday"
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
}
