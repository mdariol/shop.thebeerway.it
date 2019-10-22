<?php

namespace App\Listeners;

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
            'App\Listeners\OrderEventSubscriber@updateRequestedStock'
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
     * Send requested order.
     *
     * @param  \SM\Event\TransitionEvent $event
     */
    public function sendRequestedOrderEmail(TransitionEvent $event)
    {
        if ($event->getTransition() !== 'send') return;

        /** @var \App\Order $order */
        $order = $event->getStateMachine()->getObject();

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

        Mail::to($order->billing_profile->users)->send(new \App\Mail\ResetOrderSent($order));
    }
}
