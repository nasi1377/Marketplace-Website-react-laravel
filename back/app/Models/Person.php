<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table  = 'users';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'right_user_id',
        'left_user_id',
        'right_score',
        'left_score',
        'credit',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


}
