<?php

namespace App\Listeners;

use App\Events\BillingProfileCreated;
use App\User;
use Illuminate\Support\Facades\Mail;
use SM\Event\SMEvents;
use SM\Event\TransitionEvent;

class BillingProfileEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            SMEvents::POST_TRANSITION,
            'App\Listeners\BillingProfileEventSubscriber@assignPublicanRole'
        );

        $events->listen(
            SMEvents::POST_TRANSITION,
            'App\Listeners\BillingProfileEventSubscriber@removePubicanRole'
        );

        $events->listen(
            BillingProfileCreated::class,
            'App\Listeners\BillingProfileEventSubscriber@sendCompanyApprovalEmail'
        );

        $events->listen(
            SMEvents::POST_TRANSITION,
            'App\Listeners\BillingProfileEventSubscriber@sendCompanyApprovedEmail'
        );
    }

    /**
     * Send approved email to billing-profile's users.
     *
     * @param  \SM\Event\TransitionEvent  $event
     */
    public function sendCompanyApprovedEmail(TransitionEvent $event)
    {
        if ($event->getStateMachine()->getGraph() !== 'approval'
            || $event->getTransition() !== 'approve') return;

        /** @var \App\BillingProfile $billingProfile */
        $billingProfile = $event->getStateMachine()->getObject();

        Mail::to($billingProfile->users)
            ->send(new \App\Mail\BillingProfileApproved($billingProfile));
    }

    /**
     * Send approval email to admins.
     *
     * @param  \App\Events\BillingProfileCreated  $event
     */
    public function sendCompanyApprovalEmail(BillingProfileCreated $event)
    {
        $admins = User::role('Admin')->get();

        Mail::to($admins)->send(new \App\Mail\BillingProfileCreated($event->billingProfile));
    }

    /**
     * Assign Publican role to billing-profile's users.
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
     * Remove Publican role to billing-profile's users.
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
            if ($user->isHoreca()) continue;

            $user->removeRole('Publican');
        }
    }
}
