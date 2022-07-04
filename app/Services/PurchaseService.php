<?php
namespace App\Services;

use App\Models\Ppn;
use Illuminate\Database\Eloquent\Collection;

class PurchaseService
{
    public static function totalPrice(Collection $purchaseDetail)
    {
        return $purchaseDetail->sum(function ($purchase) {
            return self::priceWithPpn($purchase->price);
        });
    }

    public static function priceWithPpn(int $price)
    {
        $ppn = Ppn::first()->ppn;

        return $price + $price * ($ppn / 100);
    }
}
