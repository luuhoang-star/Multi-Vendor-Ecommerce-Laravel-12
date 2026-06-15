<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //Đây là danh sách các cột được phép gán hàng loạt (mass assignment) trong Laravel.
    protected $fillable = [
        'id',
        'seller_id', // seller_id là cột dùng để xác định store thuộc về vendor nào
        'logo',
        'banner',
        'name',
        'email',
        'phone',
        'address',
        'short_description',
        'long_description',
    ];
}
