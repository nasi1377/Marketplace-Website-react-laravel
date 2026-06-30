<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class RequestM extends Model
{
    use HasFactory;

    protected $table = 'request_money';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'value',
        'created_at',
        'updated_at',
        'status',
        'type',
        'id_rice',
        'totalRice',
    ];

    public function displayStatus() 
    {
        switch($this->status) {
            case 0   : return "<span class='badge badge-warning'>در انتظار بررسی</span>"; break;
            case 1    : return "<span class='badge badge-info'>پرداخت شده</span>"; break;
            default          : return "<span class='badge badge-info'>{$this->status}</span>"; break;
        }
    }



    public function User()
    {
        return $this->belongsTo(Voyager::modelClass('User'), 'user_id', 'id');
    }


}
