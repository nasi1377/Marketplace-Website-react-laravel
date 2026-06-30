<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Morilog\Jalali\CalendarUtils;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'show',
        'author_id',
        'user_id'
    ];

    public function send_msg($user_id , $msg){
        $msg_id = Message::insertGetId([
            'message'=> $msg,
            'author_id'=>Auth::user()->id,
            'user_id'=> $user_id,
            'created_at' => Carbon::now()
       ]);

        return $msg_id;

    }

    public function read_msg($author_id){
      
    
        $msgs = Message::orWhere(function ($query) use ($author_id) {
            $query->where('author_id', $author_id)
                  ->where('user_id', Auth::user()->id);
        })->orWhere(function ($query) use ($author_id) {
            $query->where('author_id',Auth::user()->id)
                  ->where('user_id',  $author_id);
        })->get();

      
     
        return $msgs;

    }
    public function read_only_msg($author_id){
      
    
        $msgs = Message::where('author_id', $author_id)->where('user_id', Auth::user()->id)->get();

        foreach($msgs as $msg){
            
                $msg->show=1;
                $msg->save();
        
        }
     
        return true;

    }
    

    public function notify_msg($author_id=null){
        if($author_id != null){
            $msgs = Message::where('show',0)->where('author_id',$author_id)->where('user_id',Auth::user()->id)->count();

        }else{
            $msgs = Message::where('show',0)->where('user_id',Auth::user()->id)->count();
        }
     
        return $msgs;

    }

    public function delete_msg($msg_id){

        $msges = Message::where('id',$msg_id)->where('author_id',Auth::user()->id)->delete();

     
        return true;

    }

}
