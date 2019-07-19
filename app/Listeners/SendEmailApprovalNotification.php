<?php

namespace App\Listeners;

use App\Mail\Approval;
use App\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class SendEmailApprovalNotification
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
    public function handle(Verified $event)
    {
        if ( ! $event->user->ishoreca) return;

        $admins = User::role('Admin')->get();

        Mail::to($admins)->send(new Approval($event->user));
    }
}
