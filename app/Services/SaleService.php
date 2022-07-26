<?php

namespace App\Services;

use App\Models\Sale;

class SaleService
{
    public static function totalPrice(Sale $sale)
    {
        return $sale->saleDetail->sum(function ($saleDetail) {
            return $saleDetail->price * $saleDetail->qty;
        });
    }
}
