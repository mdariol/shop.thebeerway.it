<?php

namespace App\Listeners;

use App\Mail\AuthRegistered;
use App\User;
use Illuminate\Auth\Events\Login;
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

        $events->listen(
            Login::class,
            'App\Listeners\AuthEventSubscriber@notifyMissingBillingProfile'
        );
    }

    /**
     * Send email on user registration.
     *
     * @param \Illuminate\Auth\Events\Registered $event
     */
    public function sendAuthRegisteredEmail(Registered $event)
    {
        $internalNotifications = User::role('InternalNotifications')->get();

        Mail::to($internalNotifications)->send(new AuthRegistered($event->user));
    }

    /**
     * Notify user is missing a billing profile.
     */
    public function notifyMissingBillingProfile(Login $event)
    {
        if ( ! $event->user->billing_profiles()->exists()) {
            session()->flash('missing_billingProfile', true);
        }
    }
}
