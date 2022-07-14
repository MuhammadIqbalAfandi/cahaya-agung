<?php

namespace App\Models;

use App\Services\HelperService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "purchase_number", "product_number"];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $ppn = Ppn::first()->ppn;

                return $this->purchase->ppn
                    ? HelperService::addPPN($value, $ppn)
                    : $value;
            }
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_number", "number");
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, "purchase_number", "number");
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
                $query->whereHas("purchase", function ($query) use ($search) {
                    $query->where("supplier_id", $search);
                });
            });
    }
}
