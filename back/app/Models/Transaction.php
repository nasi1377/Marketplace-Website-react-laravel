<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'left_score',
        'right_score',
        'total_score',
        'value',
        'type',
        'rice_amount',
        'id_rice',
       
    ];

    public function User()
    {
        return $this->belongsTo(Voyager::modelClass('User'), 'user_id', 'id');
    }



    // app/Models/Transaction.php
    public function riceProduct()
    {
        return $this->belongsTo(Product::class, 'id_rice');
    }
}
