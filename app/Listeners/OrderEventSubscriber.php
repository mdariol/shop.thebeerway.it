<?php

namespace App\Listeners;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use SM\Event\SMEvents;
use SM\Event\TransitionEvent;

class OrderEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            SMEvents::PRE_TRANSITION,
            'App\Listeners\OrderEventSubscriber@decreaseAvailableQuantity'
        );

        $events->listen(
            SMEvents::PRE_TRANSITION,
            'App\Listeners\OrderEventSubscriber@increaseAvailableQuantity'
        );

        $events->listen(
            SMEvents::PRE_TRANSITION,
            'App\Listeners\OrderEventSubscriber@decreaseStockQuantity'
        );

        $events->listen(
            SMEvents::POST_TRANSITION,
            'App\Listeners\OrderEventSubscriber@setOrderAttributes'
        );

        $events->listen(
            SMEvents::POST_TRANSITION,
            'App\Listeners\OrderEventSubscriber@sendRequestedOrderEmail'
        );

        $events->listen(
            SMEvents::POST_TRANSITION,
            'App\Listeners\OrderEventSubscriber@sendCanceledOrderEmail'
        );

        $events->listen(
            SMEvents::POST_TRANSITION,
            'App\Listeners\OrderEventSubscriber@sendResetOrderEmail'
        );
    }

    public function decreaseAvailableQuantity(TransitionEvent $event)
    {
        if ($event->getTransition() !== 'send') return;

        $order = $event->getStateMachine()->getObject();

        $order->lines->each(function ($line) {
            warehouse()->bind($line->beer, $line->qty);
        });
    }

    public function decreaseStockQuantity(TransitionEvent $event)
    {
        if ($event->getTransition() !== 'ship') return;

        $order = $event->getStateMachine()->getObject();

        $order->lines->each(function ($line) {
            warehouse()->decrease($line->beer, $line->qty);
        });
    }

    public function increaseAvailableQuantity(TransitionEvent $event)
    {
        if ($event->getTransition() !== 'cancel') return;

        $order = $event->getStateMachine()->getObject();

        $order->lines->each(function ($line) {
            warehouse()->unbind($line->beer, $line->qty);
        });
    }

    /**
     * Add qty to requested stock field on beers.
     *
     * @param \SM\Event\TransitionEvent $event
     */
    public function updateRequestedStock(TransitionEvent $event)
    {
        $transition = $event->getTransition();

        if ($transition !== 'send'
            && $transition !== 'cancel'
            && $transition !== 'ship') return;

        $order = $event->getStateMachine()->getObject();

        foreach ($order->lines as $line) {
            if ($transition == 'send') {
                $line->beer->update([
                    'requested_stock' => $line->beer->requested_stock + $line->qty
                ]);

                continue;
            }

            $line->beer->update([
                'requested_stock' => $line->beer->requested_stock - $line->qty
            ]);
        }
    }

    /**
     * Set order's number and purchased date.
     *
     * @param  TransitionEvent  $event
     */
    public function setOrderAttributes(TransitionEvent $event)
    {
        if ($event->getTransition() !== 'send') return;

        /** @var \App\Order $order */
        $order = $event->getStateMachine()->getObject();

        $order->update([
            'number' => $order->number ?: DB::table('orders')->max('number') + 1,
            'date' => \Carbon\Carbon::now('Europe/Rome')->format('Y-m-d'),
        ]);
    }

    /**
     * Send requested order.
     *
     * @param  \SM\Event\TransitionEvent $event
     */
    public function sendRequestedOrderEmail(TransitionEvent $event)
    {
        if ($event->getTransition() !== 'send') return;

        /** @var \App\Order $order */
        $order = $event->getStateMachine()->getObject();

        $admins = User::role('Admin')->get();
        Mail::to($admins)->send(new \App\Mail\RequestedOrderSent($order));
        Mail::to($order->billing_profile->users)->send(new \App\Mail\RequestedOrderSent($order));
    }

    /**
     * Send canceled order.
     *
     * @param  \SM\Event\TransitionEvent $event
     */
    public function sendCanceledOrderEmail(TransitionEvent $event)
    {
        if ($event->getTransition() !== 'cancel') return;

        /** @var \App\Order $order */
        $order = $event->getStateMachine()->getObject();

        $admins = User::role('Admin')->get();
        Mail::to($admins)->send(new \App\Mail\CanceledOrderSent($order));
        Mail::to($order->billing_profile->users)->send(new \App\Mail\CanceledOrderSent($order));
    }

    /**
     * Send reset order.
     *
     * @param  \SM\Event\TransitionEvent $event
     */
    public function sendResetOrderEmail(TransitionEvent $event)
    {
        if ($event->getTransition() !== 'reset') return;

        /** @var \App\Order $order */
        $order = $event->getStateMachine()->getObject();

        $admins = User::role('Admin')->get();
        Mail::to($admins)->send(new \App\Mail\ResetOrderSent($order));
        Mail::to($order->billing_profile->users)->send(new \App\Mail\ResetOrderSent($order));
    }
}
