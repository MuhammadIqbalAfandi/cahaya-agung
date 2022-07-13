<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "purchase_number", "product_number"];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_number", "number");
    }

    public function supplier()
    {
        return $this->hasOneThrough(
            Supplier::class,
            Purchase::class,
            "number",
            "id",
            "purchase_number",
            "supplier_id"
        );
    }

    public function scopeHistoryProductPurchase($query, array $filters)
    {
        $query
            ->when($filters["productNumber"] ?? null, function (
                $query,
                $search
            ) {
                $query->whereRelation("product", "number", $search);
            })
            ->when($filters["supplierId"] ?? null, function ($query, $search) {
                $query->whereHas("supplier");
            });
    }
}
