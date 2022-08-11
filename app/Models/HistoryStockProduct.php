<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Product;
use App\Services\FunctionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryStockProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        "price",
        "qty",
        "ppn",
        "product_number",
        "sale_number",
        "purchase_number",
    ];

    protected function createdAt(): Attribute
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

                return $this->ppn ? FunctionService::ppn($value, $ppn) : $value;
            }
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_number", "number");
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
            ->when($filters["category"] ?? null, function ($query, $search) {
                $query
                    ->where("sale_number", "like", $search . "%")
                    ->orWhere("purchase_number", "like", $search . "%");
            });
    }
}
