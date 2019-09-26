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
    }

    /**
     * Update requested stock field on beers.
     *
     * @param \SM\Event\TransitionEvent $event
     */
    public function updateRequestedStock(TransitionEvent $event)
    {
 //       dd($event->getStateMachine()->getObject()->getAttribute('id'));
        $order = Order::find($event->getStateMachine()->getObject()->getAttribute('id'));

        foreach ($order->lines as $line) {
            $beer = Beer::find($line->beer_id);
            $new_requested_stock = $beer->requested_stock + $line->qty;
            $beer->update(['requested_stock' => $new_requested_stock]);
        }

    }
}
