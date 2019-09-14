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
        'route' => 'required',
        'postal_code' => 'required',
        'city' => 'required',
        'district' => 'required',
        'country' => 'required',
        'vat_number' => 'required|alpha_num|size:11',
        'pec' => 'nullable|email',
        'sdi' => 'nullable|alpha_num|min:6|max:7',
    ];

    /**
     * CompanyController constructor.
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
        return view('company.index')->with([
            'companies' => auth()->user()->companies,
        ]);
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
        $company = Company::create(request()->validate(self::RULES) + [
            'owner_id' => auth()->id(),
        ]);

        $company->users()->attach(auth()->user());

        if (request()->has('is_default')) {
            $company->default();
        }

        return redirect()->route('companies.show', ['company' => $company->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return view('company.show')->with([
            'company' => $company,
            'state' => $this->prepareState($company),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Company $company)
    {
        $this->authorize('update', $company);

        return view('company.edit')->with([
            'company' => $company,
            'state' => $this->prepareState($company),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Company $company)
    {
        $this->authorize('update', $company);

        $company->update(request()->validate(self::RULES));

        if (request()->has('is_default')) {
            $company->default();
        }

        return redirect()->route('companies.show', ['company' => $company->id]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Company $company)
    {
        $this->authorize('delete', $company);

        return view('company.delete')->with(['company' => $company]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        // TODO: Implement soft delete.
        $this->authorize('delete', $company);

        // TODO: Use model event to detach the relationship.
        $company->users()->detach();

        $company->delete();

        return redirect()->route('companies.index');
    }

    /**
     * Set the specified resource as default.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function default(Company $company)
    {
        $this->authorize('default', $company);

        if (request()->has('is_default')) {
            $company->default();
        }

        return back();
    }

    /**
     * Approve or reject the specified resource.
     *
     * @param  \App\Company  $company
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function approve(Company $company)
    {
        $this->authorize('approve', $company);

        if ($company->state_machine->can(request()->transition)) {
            $company->state_machine->apply(request()->transition);
            $company->save();
        }

        return back();
    }

    /**
     * Prepare state variable for company.show view.
     *
     * @param  \App\Company  $company
     *
     * @return object
     */
    protected function prepareState(Company $company)
    {
        $state = (object) [
            'color' => 'info',
            'icon' => 'fa-question-circle',
            'title' => 'Verifica',
            'text' => 'Questa società deve essere verificata. Cosa vuoi fare?',
            'button' => 'btn-primary',
        ];

        if ($company->is_approved) {
            $state->color = 'success';
            $state->icon = 'fa-check-circle';
            $state->title = 'Approvato';
            $state->text = 'Questa società è stata approvata. Hai cambiato idea?';
            $state->button = 'btn-success';
        }

        if ($company->is_rejected) {
            $state->color = 'danger';
            $state->icon = 'fa-times-circle';
            $state->title = 'Rifiutato';
            $state->text = 'Questa società è stata rifiutata. Hai cambiato idea?';
            $state->button = 'btn-danger';
        }

        return $state;
    }
}
