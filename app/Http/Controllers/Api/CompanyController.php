<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function shippingAddress(Company $company)
    {
        $this->authorize('view', $company);

        return $company->default_shipping_address;
    }
}
