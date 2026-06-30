<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturned extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_order_id',
        'return_message',
        'author_id',
        'product_id',
        'weight',
        'mobile'
    ];

    protected $table = 'product_returned'; // تعیین نام دقیق جدول
}
