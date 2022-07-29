<?php

namespace App\Models;

use Carbon\Carbon;
use App\Services\FunctionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "sale_number", "product_number"];

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->translatedFormat(
                "l d/m/y"
            )
        );
    }

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

    public function scopeFilter($query, array $filters)
    {
        $query
            ->when($filters["start_date"] ?? null, function ($query, $search) {
                $query->whereDate("created_at", ">=", $search);
            })
            ->when($filters["end_date"] ?? null, function ($query, $search) {
                $query->whereDate("created_at", "<=", $search);
            });
    }
}
