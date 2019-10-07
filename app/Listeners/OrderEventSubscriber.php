<?php

namespace App\Listeners;

use App\Mail\AuthRegistered;
use App\User;
use App\Order;
use App\Beer;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
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
    }

    /**
     * Add qty to requested stock field on beers.
     *
     * @param \SM\Event\TransitionEvent $event
     */
    public function updateRequestedStock(TransitionEvent $event)
    {
        $transition = $event->getTransition();

        if ($transition !== 'send' and $transition !== 'cancel') return;

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

        $order = $event->getStateMachine()->getObject();

        Mail::to($order->company->users)->send(new \App\Mail\OrderSent($order));
    }


}
