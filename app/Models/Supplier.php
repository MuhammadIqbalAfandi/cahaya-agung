<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ["name", "address", "phone", "email", "npwp"];

    protected $hidden = ["created_at", "updated_at"];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function scopeSearch($query, array $filters)
    {
        $query->when($filters["search"] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where("name", "like", "%" . $search . "%")
                    ->orWhere("phone", "like", "%" . $search . "%")
                    ->orWhere("npwp", "like", "%" . $search . "%");
            });
        });
    }
}
