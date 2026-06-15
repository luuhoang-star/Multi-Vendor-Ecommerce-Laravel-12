<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //1 user có 1 hồ sơ KYC
    function kyc(): HasOne
    {
        return $this->hasOne(Kyc::class);
    }

    // 1 user có 1 store,và bảng stores liên kêt vs bảng users = cột seller_id
    function store(): HasOne
    {
        return $this->hasOne(Store::class, 'seller_id');
     
    }
}
