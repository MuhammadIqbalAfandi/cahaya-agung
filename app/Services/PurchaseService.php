<?php
namespace App\Services;

use App\Models\Ppn;
use App\Models\Purchase;

class PurchaseService
{
    public static function totalPrice(Purchase $purchase)
    {
        return $purchase->purchaseDetail->sum(function ($purchaseDetail) use (
            $purchase
        ) {
            $ppn = Ppn::first()->ppn;

            return $purchase->ppn
                ? $purchaseDetail->price + $purchaseDetail->price * ($ppn / 100)
                : $purchaseDetail->price;
        });
    }
}
