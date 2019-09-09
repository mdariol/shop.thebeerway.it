<?php

namespace App\Http\Controllers;

use App\Company;
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
     * Show the form for creating a new resource.
     *
     * @param \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        return view('shipping-address.create')->with(['company' => $company]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Company $company)
    {
        /** @var \App\ShippingAddress $shippingAddress */
        $shippingAddress = ShippingAddress::create(request()->validate(self::RULES) + [
            'company_id' => $company->id
        ]);

        if (request()->has('is_default')) {
            $shippingAddress->default();
        }

        return redirect()->route('companies.show', ['company' => $company->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Company $company, ShippingAddress $shippingAddress)
    {
        $this->authorize('update', $shippingAddress);

        return view('shipping-address.edit')->with([
            'company' => $company,
            'shippingAddress' => $shippingAddress,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Company  $company
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Company $company, ShippingAddress $shippingAddress)
    {
        $this->authorize('update', $shippingAddress);

        $shippingAddress->update(request()->validate(self::RULES));

        if (request()->has('is_default')) {
            $shippingAddress->default();
        }

        return redirect()->route('companies.show', ['company' => $company->id]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Company  $company
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Company $company, ShippingAddress $shippingAddress)
    {
        $this->authorize('delete', $shippingAddress);

        return view('shipping-address.delete')->with([
            'company' => $company,
            'shippingAddress' => $shippingAddress,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Company $company, ShippingAddress $shippingAddress)
    {
        $this->authorize('delete', $shippingAddress);

        $shippingAddress->delete();

        return redirect()->route('companies.show', ['company' => $company->id]);
    }

    /**
     * Set the specified resource as default.
     *
     * @param  \App\Company  $company
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function default(Company $company, ShippingAddress $shippingAddress)
    {
        $this->authorize('default', $shippingAddress);

        if (request()->has('is_default')) {
            $shippingAddress->default();
        }

        return redirect()->route('companies.show', [$company->id]);
    }
}
