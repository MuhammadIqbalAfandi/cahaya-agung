<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["name", "username", "status", "password", "role_id"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "created_at",
        "updated_at",
        "password",
        "remember_token",
    ];

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value
                ? __("words.active")
                : __("words.not_active")
        );
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeSearch($query, array $filters)
    {
        $query->when($filters["search"] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where("name", "like", "%" . $search . "%")
                    ->orWhere("username", "like", "%" . $search . "%");
            });
        });
    }
}
