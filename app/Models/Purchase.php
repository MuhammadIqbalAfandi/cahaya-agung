<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'ppn11',
        'qty',
        'product_number',
        'product_id',
        'supplier_id',
        'user_id'
    ];
}
