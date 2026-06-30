<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class RequestM extends Model
{
    use HasFactory;

    public function displayStatus() 
    {
        switch($this->status) {
            case 0   : return "<span class='badge badge-warning'>در انتظار بررسی</span>"; break;
            case 1    : return "<span class='badge badge-info'>پرداخت شده</span>"; break;
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
