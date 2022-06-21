<?php

namespace App\Models;

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

    public function saleDetail()
    {
        return $this->hasOne(SaleDetail::class);
    }

    public function saleDetailProduct()
    {
        return $this->belongsToMany(Product::class, SaleDetail::class);
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
