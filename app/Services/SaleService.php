<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public static function totalPrice(Sale $sale)
    {
        return $sale->saleDetail->sum(function ($saleDetail) {
            return $saleDetail->price * $saleDetail->qty;
        });
    }

    public static function saleAmount()
    {
        return QueryService::queryAmount("sales", "Penjualan");
    }

    public static function bestSelling()
    {
        return DB::table("sale_details")
            ->selectRaw(
                "product_number, products.name as title, SUM(qty) as qty, products.profit"
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

    public static function saleStatistic()
    {
        return DB::table("sales")
            ->selectRaw("COUNT(*) as amount")
            ->groupByRaw("MONTH(sales.created_at)")
            ->get();
    }
}
