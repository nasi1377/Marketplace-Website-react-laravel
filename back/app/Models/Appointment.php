<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
class Appointment extends Model
{
    protected $fillable = [
        'service_id',
        'barber_id',
        'user_id',
        'appointment_date',
        'appointment_time',
        'status'
    ];

    public function service()
    {
        return $this->belongsTo(HairstylistService::class,'service_id');
    }

    public function barber()
    {
        return $this->belongsTo(User::class,'barber_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}