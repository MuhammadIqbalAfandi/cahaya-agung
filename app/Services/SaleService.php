<?php

namespace App\Services;

use App\Models\Ppn;
use App\Models\Sale;
use App\Services\HelperService;

class SaleService
{
    public static function totalPrice(Sale $sale)
    {
        return $sale->saleDetail->sum(function ($saleDetail) {
            return $saleDetail->price * $saleDetail->qty;
        });
    }
}
