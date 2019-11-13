<?php

namespace App\Http\Controllers;

use App\BillingProfile;
use App\User;

class BillingProfileController extends Controller
{
    /**
     * Validation rules.
     */
    const RULES = [
        'name' => 'required', 'route' => 'required',
        'postal_code' => 'required', 'city' => 'required',
        'district' => 'required', 'country' => 'required',
        'vat_number' => 'required', 'pec' => 'nullable|email',
        'sdi' => 'nullable|alpha_num|min:6|max:7',
    ];

    /**
     * BillingProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('billing-profile.index')->with([
            'billingProfiles' => auth()->user()->billing_profiles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        if ( ! request()->has('legal_person')) {
//            return view('billing-profile.choice');
//        }

        return view('billing-profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin') && request()->has('user')) {
            request()->validate(['user' => 'exists:users,id']);

            $user = User::find(request()->user);
        }

        /** @var \App\BillingProfile $billing_profile */
        $billing_profile = BillingProfile::create(request()->validate(self::RULES) + [
            'owner_id' => $user->id,
            'legal_person' => true,
        ]);

        $billing_profile->users()->attach($user);

        if (request()->has('is_default')) {
            $billing_profile->default();
        }

        return redirect()->route('billing-profiles.show', ['billing_profile' => $billing_profile->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BillingProfile  $billing_profile
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(BillingProfile $billing_profile)
    {
        $this->authorize('view', $billing_profile);

        return view('billing-profile.show')->with([
            'billingProfile' => $billing_profile,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillingProfile  $billing_profile
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(BillingProfile $billing_profile)
    {
        $this->authorize('update', $billing_profile);

        return view('billing-profile.edit')->with([
            'billingProfile' => $billing_profile,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(BillingProfile $billingProfile)
    {
        $this->authorize('update', $billingProfile);

        $billingProfile->update(request()->validate(self::RULES));

        if (request()->has('is_default')) {
            $billingProfile->default();
        }

        return redirect()->route('billing-profiles.show', ['billingProfile' => $billingProfile->id]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(BillingProfile $billingProfile)
    {
        $this->authorize('delete', $billingProfile);

        return view('billing-profile.delete')->with(['billingProfile' => $billingProfile]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(BillingProfile $billingProfile)
    {
        // TODO: Implement soft delete.
        $this->authorize('delete', $billingProfile);

        // TODO: Use model event to detach the relationship.
        $billingProfile->users()->detach();

        $billingProfile->delete();

        return redirect()->route('billing-profiles.index');
    }

    /**
     * Set the specified resource as default.
     *
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function default(BillingProfile $billingProfile)
    {
        $this->authorize('default', $billingProfile);

        $billingProfile->default();

        return back();
    }

    /**
     * Apply transition to specified resource.
     *
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function transition(BillingProfile $billingProfile)
    {
        $this->authorize('transition', $billingProfile);

        $billingProfile->state_machine->apply(request()->transition);
        $billingProfile->save();

        return back();
    }

    /**
     * Get default or fisrt shipping-address of the specified resource.
     *
     * @param  BillingProfile  $billingProfile
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function shippingAddress(BillingProfile $billingProfile)
    {
        $this->authorize('view', $billingProfile);

        if (request()->wantsJson()) {
            return $billingProfile->shippingAddress();
        }

        abort(404);
    }
}
