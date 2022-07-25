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

    public static function productAmount()
    {
        return QueryService::queryAmount("products", "Produk");
    }

    public static function stockProductAmount()
    {
        return QueryService::queryAmount("stock_products", "Stok Produk");
    }
}
