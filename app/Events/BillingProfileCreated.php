<?php

namespace App\Events;

use App\BillingProfile;

class BillingProfileCreated
{
    public $billingProfile;

    /**
     * Create a new event instance.
     *
     * @param \App\BillingProfile $billingProfile
     *
     * @return void
     */
    public function __construct(BillingProfile $billingProfile)
    {
        $this->billingProfile = $billingProfile;
    }
}
