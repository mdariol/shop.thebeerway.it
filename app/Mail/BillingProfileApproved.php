<?php

namespace App\Mail;

use App\BillingProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillingProfileApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\BillingProfile
     */
    public $billingProfile;

    /**
     * Create a new message instance.
     *
     * @param \App\BillingProfile $billingProfile
     *
     * @return void
     */
    public function __construct(BillingProfile $billingProfile)
    {
        $this->billingProfile = $billingProfile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Società riconosciuta!')
            ->markdown('emails.billing-profile.approved');
    }
}
