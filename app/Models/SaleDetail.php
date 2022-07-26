<?php

namespace App\Models;

use App\Services\FunctionService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "sale_number", "product_number"];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $ppn = Ppn::first()->ppn;

                return $this->sale->ppn
                    ? FunctionService::ppn($value, $ppn)
                    : $value;
            }
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_number", "number");
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, "sale_number", "number");
    }

    public function scopeHistoryProductSale($query, array $filters)
    {
        $query
            ->when($filters["productNumber"] ?? null, function (
                $query,
                $search
            ) {
                $query->where("product_number", $search);
            })
            ->when($filters["customerId"] ?? null, function ($query, $search) {
                $query->whereHas("sale", function ($query) use ($search) {
                    $query->where("customer_id", $search);
                });
            });
    }
}
