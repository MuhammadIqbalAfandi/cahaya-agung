<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_number',
        'sale_number',
        'amount',
        'product_number'
    ];
}
