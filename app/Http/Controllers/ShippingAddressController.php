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
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
    ];

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
        ShippingAddress::create(request()->validate(self::RULES) + [
            'company_id' => $company->id
        ]);

        return redirect()->route('companies.show', ['company' => $company->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Company $company
     * @param  \App\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, ShippingAddress $shippingAddress)
    {
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
     * @return \Illuminate\Http\Response
     */
    public function update(Company $company, ShippingAddress $shippingAddress)
    {
        $shippingAddress->update(request()->validate(self::RULES));

        return redirect()->route('companies.show', ['company' => $company->id]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param \App\Company $company
     * @param \App\ShippingAddress $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function delete(Company $company, ShippingAddress $shippingAddress)
    {
        return view('shipping-address.delete')->with([
            'company' => $company,
            'shippingAddress' => $shippingAddress,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Company $company
     * @param  \App\ShippingAddress  $shippingAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, ShippingAddress $shippingAddress)
    {
        $shippingAddress->delete();

        return redirect()->route('companies.show', ['company' => $company->id]);
    }
}
