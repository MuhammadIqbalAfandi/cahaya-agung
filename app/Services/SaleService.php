<?php

namespace App\Services;

use App\Models\Ppn;
use App\Models\Sale;
use App\Services\HelperService;

class SaleService
{
    public static function totalPrice(Sale $sale)
    {
        return $sale->saleDetail->sum(function ($saleDetail) use ($sale) {
            $ppn = Ppn::first()->ppn;

            return $sale->ppn
                ? HelperService::ppn($saleDetail->price, $ppn)
                : $saleDetail->price;
        });
    }
}
