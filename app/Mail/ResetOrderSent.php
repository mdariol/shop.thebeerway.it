<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Order;


class ResetOrderSent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Order
     */
    public $order;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('The BeerWay: Richiesta d\'ordine riaperta')->markdown('emails.orders.sent-reset');
    }
}
