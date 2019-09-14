<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        return view('company.admin.index')->with([
            'companies' => Company::queryFilter()->orderBy('business_name')->get(),
            'users' => \App\User::all()
        ]);
    }
}
