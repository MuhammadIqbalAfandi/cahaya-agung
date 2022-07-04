<?php

namespace App\Models;

use App\Services\HelperService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "price",
        "ppn",
        "qty",
        "sale_number",
        "product_number",
    ];
}
