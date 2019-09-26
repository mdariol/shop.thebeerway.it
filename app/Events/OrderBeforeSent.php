<?php

namespace App\Events;

use App\Order;

class OrderBeforeSent
{
    public $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Company $company
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
