<?php

namespace App\Listeners;

use App\Events\CompanyCreated;
use App\User;
use Illuminate\Support\Facades\Mail;
use SM\Event\SMEvents;
use SM\Event\TransitionEvent;

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
//            SMEvents::POST_TRANSITION,
//            'App\Listeners\CompanyEventSubscriber@assignPublicanRole'
//        );

//        $events->listen(
//            SMEvents::POST_TRANSITION,
//            'App\Listeners\CompanyEventSubscriber@removePubicanRole'
//        );

        $events->listen(
            CompanyCreated::class,
            'App\Listeners\CompanyEventSubscriber@sendCompanyApprovalEmail'
        );

        $events->listen(
            SMEvents::POST_TRANSITION,
            'App\Listeners\CompanyEventSubscriber@sendCompanyApprovedEmail'
        );
    }

    /**
     * Send approved email to company's users.
     *
     * @param  \SM\Event\TransitionEvent  $event
     */
    public function sendCompanyApprovedEmail(TransitionEvent $event)
    {
        if ($event->getStateMachine()->getGraph() !== 'approval'
            || $event->getTransition() !== 'approve') return;

        /** @var \App\Company $company */
        $company = $event->getStateMachine()->getObject();

        Mail::to($company->users)
            ->send(new \App\Mail\CompanyApproved($company));
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
     * @param \SM\Event\TransitionEvent $event
     */
    public function assignPublicanRole(TransitionEvent $event)
    {
        if ($event->getStateMachine()->getGraph() !== 'approval'
            || $event->getTransition() !== 'approve') return;

        $users = $event->getStateMachine()->getObject()->users;

        /** @var \App\User $user */
        foreach ($users as $user) {
            $user->assignRole('Publican');
        }
    }

    /**
     * Remove Publican role to company's users.
     *
     * @param \SM\Event\TransitionEvent $event
     */
    public function removePublicanRole(TransitionEvent $event)
    {
        if ($event->getStateMachine()->getGraph() !== 'approval'
            || $event->getTransition() !== 'reject') return;

        $users = $event->getStateMachine()->getObject()->users;

        /** @var \App\User $user */
        foreach ($users as $user) {
            if ($user->is_horeca) continue;

            $user->removeRole('Publican');
        }
    }
}
