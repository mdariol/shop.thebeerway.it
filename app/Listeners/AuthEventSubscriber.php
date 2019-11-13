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
            'App\Listeners\AuthEventSubscriber@loadCartFromDraftOrder'
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
        $admins = User::role('Admin')->get();

        Mail::to($admins)->send(new AuthRegistered($event->user));
    }

    /**
     * Load Cart from Draft Order if exist.
     *
     * @param \Illuminate\Auth\Events\Login $event
     */
    public function loadCartFromDraftOrder(Login $event)
    {
       $event->user->getDraftOrder();
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
