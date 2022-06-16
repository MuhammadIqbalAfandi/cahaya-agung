<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_number',
        'invoice_number',
        'amount',
        'product_id'
    ];
}
