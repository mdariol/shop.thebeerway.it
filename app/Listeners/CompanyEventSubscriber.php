<?php

namespace App\Listeners;

use App\Events\CompanyApproved;
use App\Events\CompanyCreated;
use App\User;
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

        $events->listen(
            CompanyCreated::class,
            'App\Listeners\CompanyEventSubscriber@sendCompanyApprovalEmail'
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
     * Send approval email to admins.
     *
     * @param  \App\Events\CompanyCreated  $event
     */
    public function sendCompanyApprovalEmail(CompanyCreated $event)
    {
        $admins = User::role('Admin')->get();

        Mail::to($admins)->send(new \App\Mail\CompanyCreated($event->company));
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
