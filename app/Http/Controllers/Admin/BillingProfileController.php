<?php

namespace App\Http\Controllers\Admin;

use App\BillingProfile;
use App\Http\Controllers\Controller;

class BillingProfileController extends Controller
{
    public function index()
    {
        return view('billing-profile.admin.index')->with([
            'billingProfiles' => BillingProfile::queryFilter()->orderBy('name')->get(),
            'users' => \App\User::all()
        ]);
    }
}
