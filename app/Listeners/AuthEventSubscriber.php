<?php

namespace App\Listeners;

use App\Mail\AuthRegistered;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class AuthEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            Registered::class,
            'App\Listeners\AuthEventSubscriber@sendAuthRegisteredEmail'
        );
    }

    /**
     * Send email on user registration.
     *
     * @param \Illuminate\Auth\Events\Registered $event
     */
    public function sendAuthRegisteredEmail(Registered $event)
    {
        $admins = User::role('Admin')->get();

        Mail::to($admins)->send(new AuthRegistered($event->user));
    }
}
