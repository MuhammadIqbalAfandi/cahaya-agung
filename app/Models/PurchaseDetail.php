<?php

namespace App\Models;

use App\Services\HelperService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = ["price", "qty", "purchase_number", "product_number"];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_number", "number");
    }
}
