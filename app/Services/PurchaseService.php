<?php

namespace App\Services;

use App\Models\Purchase;

class PurchaseService
{
    public static function totalPrice(Purchase $purchase)
    {
        return $purchase->purchaseDetail->sum(function ($purchaseDetail) {
            return $purchaseDetail->price * $purchaseDetail->qty;
        });
    }
}
