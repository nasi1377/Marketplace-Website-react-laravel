<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    // چون اسم جدولت جمع هست (product_requests)، لاراول خودش می‌شناسه 
    // ولی برای اطمینان این خط رو بذار:
    protected $table = 'product_requests';

    // فیلدهایی که اجازه ثبت دارن (بر اساس لاگ خودت)
    protected $fillable = [
        'supplier_id',
        'name', // اگر در دیتابیس name گذاشتی، اینجا هم name بذار
        'price',
        'stock',
        'excerpt',
        'body',
        'image',
        'status',
    ];


    // رابطه با مدل User (اگر تامین‌کننده در جدول users هست)
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
    
}
