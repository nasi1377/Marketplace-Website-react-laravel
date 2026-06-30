<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StylistPost extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'price', 'image', 'status'];

    // رابطه‌ی هر پست با آرایشگر (کاربر)
    public function stylist()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}