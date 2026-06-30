<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HairStylist extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'specialties', // به صورت JSON ذخیره می‌شود
        'experience_years',
        'instagram_id',
        'is_verified'
    ];

    protected $casts = [
        'specialties' => 'array',
    ];

    // رابطه با مدل کاربر اصلی
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
