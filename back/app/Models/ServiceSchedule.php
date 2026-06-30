<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSchedule extends Model
{
    protected $fillable = [
        'service_id',
        'available_date',
        'start_time',
        'end_time',
        'slot_duration'
    ];

    public function service()
    {
        return $this->belongsTo(HairstylistService::class,'service_id');
    }
}