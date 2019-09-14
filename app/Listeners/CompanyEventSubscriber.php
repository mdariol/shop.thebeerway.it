<?php

namespace App\Listeners;

use App\Events\CompanyApproved;
use Illuminate\Support\Facades\Mail;

class CompanyEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
//        $events->listen(
//            CompanyApproved::class,
//            'App\Listeners\CompanyEventSubscriber@assignPublicanRole'
//        );

        $events->listen(
            CompanyApproved::class,
            'App\Listeners\CompanyEventSubscriber@sendCompanyApprovedEmail'
        );
    }

    /**
     * Send approved email to company's users.
     *
     * @param  \App\Events\CompanyApproved  $event
     */
    public function sendCompanyApprovedEmail(CompanyApproved $event)
    {
        Mail::to($event->company->users)
            ->send(new \App\Mail\CompanyApproved($event->company));
    }

    /**
     * Assign Publican role to company's users.
     *
     * @param \App\Events\CompanyApproved $event
     */
    public function assignPublicanRole(CompanyApproved $event)
    {
        $users = $event->company->users;

        /** @var \App\User $user */
        foreach ($users as $user) {
            $user->assignRole('Publican');
        }
    }

    /**
     * Remove Publican role to company's users.
     *
     * @param $event
     */
    public function removePublicanRole($event)
    {
        $users = $event->company->users;

        /** @var \App\User $user */
        foreach ($users as $user) {
            if ($user->is_horeca) continue;

            $user->removeRole('Publican');
        }
    }
}
