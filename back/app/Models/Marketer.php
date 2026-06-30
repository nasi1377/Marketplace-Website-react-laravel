<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Marketer extends Model
{
    use HasFactory;

    protected $table = 'marketers';

    protected $fillable = [
        'left_user_id',
        'right_user_id',
        'inviter',
        'name'
    ];

    public function leftUser()
    {
        return $this->belongsTo(User::class, 'left_user_id', 'id');
    }

    public function rightUser()
    {
        return $this->belongsTo(User::class, 'right_user_id', 'id');
    }

    public function inviterUser()
    {
        return $this->belongsTo(User::class, 'inviter', 'id');
    }

}
