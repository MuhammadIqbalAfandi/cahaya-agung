<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'status',
        'supplier_id',
        'user_id'
    ];

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get:fn($value) => Carbon::parse($value)->translatedFormat('l d/m/y')
        );
    }

    public function purchaseDetail()
    {
        return $this->hasOne(PurchaseDetail::class, 'purchase_number', 'number');
    }

    public function product()
    {
        return $this->hasOneThrough(
            Product::class,
            PurchaseDetail::class,
            'purchase_number',
            'number',
            'number',
            'product_number'
        );
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('number', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        });
    }
}
