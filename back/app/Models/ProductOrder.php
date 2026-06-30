<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductOrder extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'message_referred', 'weight']; // اضافه کردن status

    public function displayStatus() 
    {
        switch($this->status) {
            case 'PENDING'   : return "<span class='badge badge-warning'>در انتظار پرداخت</span>"; break;
            case 'PROCESSED' : return "<span class='badge badge-primary'>ثبت شده</span>"; break;
            case 'POSTED'    : return "<span class='badge badge-info'>ارسال شده</span>"; break;
            case 'DELIVERED' : return "<span class='badge badge-success'>تحویل شده</span>"; break;
            case 'REFERRED'  : return "<span class='badge badge-danger'>مرجوع شده</span>"; break;
            default          : return "<span class='badge badge-info'>{$this->status}</span>"; break;
        }
    }

    public function displayProduct()
    {
        $product = Product::whereId($this->product_id)->first();
        $name = $product->title ?? 'بدون نام';
        if($this->type === 'MAJOR') {
            $name .= "<small style='color:silver'> ({$this->weight} کیلو)</small>";
        }

        return $name;
    }

    public function displayType()
    {
        if($this->type === 'SINGLE') {
            return "<span class='badge badge-info'>تکی</span>"; 
        } else {
            return "<span class='badge badge-info'>عمده</span>"; 
        }
    }
}
