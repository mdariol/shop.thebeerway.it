<?php

namespace App\Http\Controllers;

use App\BillingProfile;
use App\ShippingAddress;

class ShippingAddressController extends Controller
{
    /**
     * Validation rules.
     */
    const RULES = [
        'name' => 'required', 'route' => 'required',
        'postal_code' => 'required', 'city' => 'required',
        'district' => 'required', 'country' => 'required',
        'phone' => 'nullable|regex:/^\+?[0-9 ]*/'
    ];

    /**
     * ShippingAddressController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param  BillingProfile  $billingProfile
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BillingProfile $billingProfile) {
        if (request()->wantsJson()) {
            return $billingProfile->shipping_addresses;
        }

        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\BillingProfile  $billingProfile
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BillingProfile $billingProfile)
    {
        return view('shipping-address.create')->with(['billingProfile' => $billingProfile]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\BillingProfile $billingProfile
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BillingProfile $billingProfile)
    {
        /** @var \App\ShippingAddress $shippingAddress */
        $shippingAddress = ShippingAddress::create(request()->validate(self::RULES) + [
            'billing_profile_id' => $billingProfile->id
        ]);

        if (request()->has('is_default')) {
            $shippingAddress->default();
        }

        return redirect()->route('billing-profiles.show', ['billing_profile' => $billingProfile->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillingProfile  $billingProfile
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BillingProfile $billingProfile, ShippingAddress $shippingAddress)
    {
        $this->authorize('update', $shippingAddress);

        return view('shipping-address.edit')->with([
            'billingProfile' => $billingProfile,
            'shippingAddress' => $shippingAddress,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\BillingProfile  $billingProfile
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(BillingProfile $billingProfile, ShippingAddress $shippingAddress)
    {
        $this->authorize('update', $shippingAddress);

        $shippingAddress->update(request()->validate(self::RULES));

        if (request()->has('is_default')) {
            $shippingAddress->default();
        }

        return redirect()->route('billing-profiles.show', ['billing_profile' => $billingProfile->id]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\BillingProfile  $billingProfile
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(BillingProfile $billingProfile, ShippingAddress $shippingAddress)
    {
        $this->authorize('delete', $shippingAddress);

        return view('shipping-address.delete')->with([
            'billingProfile' => $billingProfile,
            'shippingAddress' => $shippingAddress,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BillingProfile  $billingProfile
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BillingProfile $billingProfile, ShippingAddress $shippingAddress)
    {
        $this->authorize('delete', $shippingAddress);

        $shippingAddress->delete();

        return redirect()->route('billing-profiles.show', ['billing_profile' => $billingProfile->id]);
    }

    /**
     * Set the specified resource as default.
     *
     * @param  \App\BillingProfile  $billingProfile
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function default(BillingProfile $billingProfile, ShippingAddress $shippingAddress)
    {
        $this->authorize('default', $shippingAddress);

        $shippingAddress->default();

        return redirect()->route('billing-profiles.show', [$billingProfile->id]);
    }
}
