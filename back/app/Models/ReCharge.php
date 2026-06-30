<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ReCharge extends Model
{
    protected $table = 'recharges';
    public $timestamps = true;
    
    protected $fillable = [
        'user_id',
        'value'
    ];

    public function User()
    {
        return $this->belongsTo(Voyager::modelClass('User'), 'user_id', 'id');
    }
}
