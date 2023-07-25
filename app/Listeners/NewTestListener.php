<?php

namespace App\Listeners;

use App\Events\NewTestCreate;
use App\Mail\UserMail;
use App\Listeners\NewTestListener;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
Use Auth;
use App\User;

class NewTestListener
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
     * @param  NewTestCreate  $event
     * @return void
     */
    public function handle(NewTestCreate $event)
    {
        $user = User::find(222);

        \Mail::to($user->email)->send(new UserMail($event->user));
    }
}
