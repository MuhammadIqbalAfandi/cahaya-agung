<?php

namespace App\Services;

use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public static function totalPrice(Purchase $purchase)
    {
        return $purchase->purchaseDetail->sum(function ($purchaseDetail) {
            return $purchaseDetail->price * $purchaseDetail->qty;
        });
    }

    public static function purchaseAmount()
    {
        return QueryService::queryAmount("purchases", "Pembelian");
    }
}
