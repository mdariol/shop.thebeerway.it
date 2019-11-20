<?php


namespace App\Listeners;


use App\Events\LineCreated;

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
            LineCreated::class,
            'App\Listeners\LineEventSubscriber@calculateOrderTotal'
        );
    }

    /**
     * Calculate order's total.
     *
     * @param LineCreated $event
     */
    public function calculateOrderTotal(LineCreated $event)
    {
        $order = $event->line->order;
        $lines = $order->lines()->select(['unit_price', 'qty'])->get();

        $order->total_amount = array_reduce($lines->toArray(), function ($carry, $line) {
            return $carry + ($line['unit_price'] * $line['qty']);
        }, 0);

        $order->save();
    }
}
