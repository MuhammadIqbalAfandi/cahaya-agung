<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public static function isUsed(Product $product)
    {
        return $product->saleDetails()->exists() ||
            $product->stockProducts()->exists() ||
            $product->purchaseDetails()->exists();
    }
}
