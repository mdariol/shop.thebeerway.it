<?php

namespace App\Http\Controllers\Api;

use App\Company;

class CompanyController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get default shipping address.
     *
     * @param  \App\Company  $company
     *
     * @return mixed
     */
    public function shippingAddress(Company $company)
    {
        $this->authorize('view', $company);

        return $company->default_shipping_address;
    }
}
