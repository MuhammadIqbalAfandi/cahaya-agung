<?php

namespace App\Models;

use Carbon\Carbon;
use App\Services\FunctionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "purchase_number", "product_number"];

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

                return $this->purchase->ppn
                    ? FunctionService::ppn($value, $ppn)
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
            ->when($filters["product_number"] ?? null, function (
                $query,
                $search
            ) {
                $query->where("product_number", $search);
            })
            ->when($filters["supplier_id"] ?? null, function ($query, $search) {
                $query->whereHas("purchase", function ($query) use ($search) {
                    $query->where("supplier_id", $search);
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
            })
            ->when($filters["status"] ?? null, function ($query, $search) {
                $query->whereHas("purchase", function ($query) use ($search) {
                    $query->where("status", $search);
                });
            });
    }
}
