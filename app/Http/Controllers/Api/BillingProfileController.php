<?php

namespace App\Http\Controllers\Api;

use App\BillingProfile;
use App\Http\Controllers\Controller;

class BillingProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get default shipping address.
     *
     * @param  \App\BillingProfile  $billing_profile
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function shippingAddress(BillingProfile $billing_profile)
    {
        $this->authorize('view', $billing_profile);

        return $billing_profile->default_shipping_address;
    }
}
