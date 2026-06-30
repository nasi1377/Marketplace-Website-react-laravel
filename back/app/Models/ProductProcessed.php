<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProcessed extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_order_id',
        'return_message',
        'author_id',
        'product_id',
        'weight',
        'size',
        'color',
        'mobile'
    ];

    protected $table = 'product_processed'; // تعیین نام دقیق جدول
}
