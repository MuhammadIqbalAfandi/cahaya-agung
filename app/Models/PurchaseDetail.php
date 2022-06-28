<?php

namespace App\Models;

use App\Services\HelperService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'ppn',
        'qty',
        'purchase_number',
        'product_number'
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get:fn($value) => HelperService::setRupiahFormat($value, true)
        );
    }

    protected function ppn(): Attribute
    {
        return Attribute::make(
            get:fn($value) => $value . '%'
        );
    }
}
