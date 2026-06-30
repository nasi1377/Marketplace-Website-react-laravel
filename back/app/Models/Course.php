<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'status'
    ];

    /**
     * آرایشگری که دوره را ثبت کرده
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
{
    return $this->belongsToMany(User::class, 'course_user')
                ->withPivot('status')
                ->withTimestamps();
}
}