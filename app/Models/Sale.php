<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ["number", "status", "customer_id", "user_id"];

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->translatedFormat(
                "l d/m/Y"
            )
        );
    }

    public function saleDetail()
    {
        return $this->hasOne(SaleDetail::class, "sale_number", "number");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeFilter($query, array $filters)
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
}
