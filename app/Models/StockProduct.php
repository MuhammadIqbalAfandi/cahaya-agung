<?php

namespace App\Models;

use App\Services\HelperService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        "purchase_number",
        "sale_number",
        "price",
        "qty",
        "product_number",
    ];

    protected function price(): Attribute
    {
        $ppn = Purchase::where("number", $this->purchase_number)->first()->ppn;

        return Attribute::make(
            get: fn($value) => HelperService::addPPN($value, $ppn)
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_number", "number");
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters["search"] ?? null, function ($query, $search) {
            $query->whereHas("product", function ($query) use ($search) {
                $query
                    ->where("number", "like", "%" . $search . "%")
                    ->orWhere("name", "like", "%" . $search . "%");
            });
        });
    }
}
