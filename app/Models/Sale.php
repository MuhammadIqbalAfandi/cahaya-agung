<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'ppn11',
        'qty',
        'invoice_number',
        'product_id',
        'customers_id',
        'user_id'
    ];
}
