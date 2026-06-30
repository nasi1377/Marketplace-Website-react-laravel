<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // جدول مورد نظر
    protected $table = 'cities';  // نام جدول cities

    // اگر نام کلید اصلی (primary key) از 'id' متفاوت باشه
    protected $primaryKey = 'code';  // در صورتی که کد شهر کلید اصلی باشد

    // اگر به صورت صریح بخواهید فیلدهای قابل پر کردن رو مشخص کنید
    protected $fillable = ['name', 'code', 'prov_id'];
}
