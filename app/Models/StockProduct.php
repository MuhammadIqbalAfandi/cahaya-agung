<?php

namespace App\Models;

use App\Models\Ppn;
use App\Services\HelperService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockProduct extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "ppn", "product_number"];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $ppn = Ppn::first()->ppn;

                return $this->ppn
                    ? HelperService::addPPN($value, $ppn)
                    : $value;
            }
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_number", "number");
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters["search"] ?? null, function ($query, $search) {
            $query
                ->whereHas("product", function ($query) use ($search) {
                    $query
                        ->where("number", "like", "%" . $search . "%")
                        ->orWhere("name", "like", "%" . $search . "%");
                })
                ->where("qty", ">", 0);
        });
    }
}
