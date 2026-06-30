<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use TCG\Voyager\Models\Role;
use App\Http\Controllers\GraphController;
use App\Traits\Graph;
use App\Models\Order;
use App\Events\NewUserRegistered;
// use App\Models\marketer;
use App\Models\Gift;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'role_id',
        'password',
        'settings',
        'right_user_id',
        'left_user_id',
        'right_score',
        'left_score',
        'credit',
        'inviter',
        'status',
        'city_id',
        'prov_id',
        'code',
        'address',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getInviteCode()
    {
        return $this->id + 561404;
    }

    public function checkExist()
    {
        return $this->IsExist($this->id);
    }

   
   

    
    public function extra($key, $default = null)
{
    // اگر داده‌هات توی یک ستون به اسم data ذخیره می‌شن:
    return $this->data[$key] ?? $default; 
    
    // یا اگر اطلاعاتت توی جدول دیگه‌ای هست، کوئری مرتبط رو بنویس.
}
    
 public function orders()
{
    return $this->hasMany(Order::class);
}   
    public function levelDisplay()
{
    // اینجا بر اساس دیتابیس فعلیت، سطحی که می‌خوای رو برگردون
    return "کاربر عادی"; 
}
    public function courses()
{
    return $this->belongsToMany(Course::class, 'course_user')
                ->withPivot('status')
                ->withTimestamps();
}
}


