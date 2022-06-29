<?php

namespace App\Models;

use App\Models\PurchaseDetail;
use App\Models\SaleDetail;
use App\Models\StockProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'unit',
        'profit'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function stockProducts()
    {
        return $this->hasMany(StockProduct::class, 'product_number', 'number');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'product_number', 'number');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class, 'product_number', 'number');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('number', 'like', '%' . $search . '%');
            });
        });
    }
}
