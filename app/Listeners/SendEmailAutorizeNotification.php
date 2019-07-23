<?php

namespace App\Listeners;

use App\Events\Autorized;
use App\Mail\Autorize;
use App\User;
use Illuminate\Support\Facades\Mail;

class SendEmailAutorizeNotification
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
     * @param  \Illuminate\Auth\Events\Verified  $event
     * @return void
     */
    public function handle(Autorized $event)
    {
        Mail::to($event->user)->send(new Autorize($event->user));
    }
}
