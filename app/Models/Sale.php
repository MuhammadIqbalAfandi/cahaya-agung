<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'status',
        'customer_id',
        'user_id'
    ];

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get:fn($value) => Carbon::parse($value)->translatedFormat('l d/m/Y H:i:s')
        );
    }

    public function saleDetail()
    {
        return $this->hasOne(SaleDetail::class);
    }

    public function product()
    {
        return $this->hasOneThrough(
            Product::class,
            SaleDetail::class,
            'sale_id',
            'number',
            'id',
            'product_id'
        );
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
