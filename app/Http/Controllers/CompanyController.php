<?php

namespace App\Http\Controllers;

use App\Company;

class CompanyController extends Controller
{
    /**
     * Validation rules.
     */
    const RULES = [
        'business_name' => 'required',
        'address' => 'required',
        'vat_number' => 'required|alpha_num|max:11',
        'pec' => 'nullable|email',
        'sdi' => 'nullable|alpha_num|min:6|max:7',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        /** @var \App\Company $company */
        $company = Company::create(request()->validate(self::RULES));

        $company->users()->attach(auth()->user());

        return redirect()->route('companies.show', ['id' => $company->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('company.edit')->with([
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Company $company)
    {
        $company->update(request()->validate(self::RULES));

        return redirect()->route('companies.show', ['id' => $company->id]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param \App\Company $company
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
