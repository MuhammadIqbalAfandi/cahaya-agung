<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ["number", "ppn", "status", "supplier_id", "user_id"];

    protected $with = ["purchaseDetail.product", "supplier"];

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->translatedFormat(
                "l d/m/y"
            )
        );
    }

    public function purchaseDetail()
    {
        return $this->hasMany(
            PurchaseDetail::class,
            "purchase_number",
            "number"
        );
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function scopeSearch($query, array $filters)
    {
        $query->when($filters["search"] ?? null, function ($query, $search) {
            $query
                ->whereHas("supplier", function ($query) use ($search) {
                    $query
                        ->where("name", "like", "%" . $search . "%")
                        ->orWhere("phone", "like", "%" . $search . "%")
                        ->orWhere("email", "like", "%" . $search . "%");
                })
                ->orWhere(function ($query) use ($search) {
                    $query->where("status", "like", "%" . $search . "%");
                });
        });
    }
}
