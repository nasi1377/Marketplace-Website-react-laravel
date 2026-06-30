<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HairstylistService extends Model
{
    use HasFactory;

    // این فیلدها اجازه دارن که به صورت دسته جمعی (Mass Assignment) مقدار بگیرن
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'image',
        'status',
    ];

    // اگر اسم جدول دیتابیس دقیقاً hairstylist_services هست، نیازی به این خط نیست
    // اما اگه اسم جدول متفاوته، اینجا تعیینش کن:
    // protected $table = 'hairstylist_services';
    public function user()
{
    return $this->belongsTo(User::class); 
}
}
