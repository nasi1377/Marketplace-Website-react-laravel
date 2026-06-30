<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Models\Marketer; 
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddToMarketers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event)
    {
        Marketer::create([
            'user_id' => $event->user->id,
            'right_user_id' => $event->user->right_user_id,
            'left_user_id' => $event->user->left_user_id,
            'inviter' => $event->user->inviter,
        ]);
    }
}
