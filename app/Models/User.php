<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public $fillable = [
        'name',
        'email',
        'password',
    ];

    public $hidden = [
        'password',
        'remember_token',
    ];

    public $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // JWT methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Example relationship (optional)
    // public function capsules()
    // {
    //     return $this->hasMany(Capsule::class);
    // }
}
