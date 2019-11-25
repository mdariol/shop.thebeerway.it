<?php

namespace App\Listeners;

use App\Events\LineChanged;

class LineEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            LineChanged::class,
            'App\Listeners\LineEventSubscriber@calculateOrderTotal'
        );
    }

    /**
     * Calculate order's total.
     *
     * @param  LineChanged  $event
     * @return bool
     */
    public function calculateOrderTotal(LineChanged $event)
    {
        /** @var \App\Order $order */
        $order = $event->line->order;
        $lines = $order->lines()->select(['unit_price', 'qty'])->get();

        if ( ! $lines->count()) {
            $order->total_amount = null;

            return $order->save();
        }

        $order->total_amount = array_reduce($lines->toArray(), function ($carry, $line) {
            return $carry + ($line['unit_price'] * $line['qty']);
        }, 0);

        return $order->save();
    }
}
