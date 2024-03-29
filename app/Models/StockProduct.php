<?php

namespace App\Models;

use App\Models\Ppn;
use App\Services\FunctionService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockProduct extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "ppn", "product_number"];

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
            ->when($filters["search"] ?? null, function ($query, $search) {
                $query->whereHas("product", function ($query) use ($search) {
                    $query
                        ->where("number", "like", "%" . $search . "%")
                        ->orWhere("name", "like", "%" . $search . "%");
                });
            })
            ->when($filters["category"] ?? null, function ($query, $search) {
                $query->where("qty", ">", 0);
            });
    }
}
