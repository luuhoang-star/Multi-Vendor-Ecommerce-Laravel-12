<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kyc extends Model
{
    protected $fillable = ['status']; // khiến k cập nhật lung tung
    function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Một bản ghi Kyc có một khóa ngoại (user_id) tham chiếu tới khóa chính (id) của bảng users.
    }
}
