<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppn extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppn'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected function ppn(): Attribute
    {
        return Attribute::make(
            get:fn($value) => $value . '%'
        );
    }
}
