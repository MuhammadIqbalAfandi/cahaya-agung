<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ["number", "ppn", "status", "customer_id", "user_id"];

    protected $with = ["saleDetail.product", "customer"];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->translatedFormat(
                "l d/m/Y"
            )
        );
    }

    public function saleDetail()
    {
        return $this->hasMany(SaleDetail::class, "sale_number", "number");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeSearch($query, array $filters)
    {
        $query->when($filters["search"] ?? null, function ($query, $search) {
            $query
                ->whereHas("customer", function ($query) use ($search) {
                    $query
                        ->where("name", "like", "%" . $search . "%")
                        ->orWhere("phone", "like", "%" . $search . "%");
                })
                ->orWhere(function ($query) use ($search) {
                    $query->where("status", "like", "%" . $search . "%");
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
            ->when($filters["product_number"] ?? null, function (
                $query,
                $search
            ) {
                $query->where("number", "like", "%" . $search . "%");
            });
    }
}
