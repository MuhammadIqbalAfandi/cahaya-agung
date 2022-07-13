<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "ppn", "product_number"];

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
