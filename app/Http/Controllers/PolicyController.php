<?php

namespace App\Http\Controllers;

use App\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('policy.index')->with('policies', Policy::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('policy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            Policy::create(request(['name','content','from_date'] ));
        } catch(QueryException $exception) {
            $exception->getCode() =='23000' ? $response='Errore di univocità: questo nome conq questa data è già presente nei dati' : $response=$exception->getMessage();
            return back()->withErrors($response)->withInput();
        }

        return redirect('/policies');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function show(Policy $policy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function edit(Policy $policy)
    {
        return view('policy.edit')->with('policy', $policy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Policy $policy)
    {
        try{
            $policy->update(request(['name','content','from_date'] ));
        } catch(QueryException $exception) {
            $exception->getCode() =='23000' ? $response='Errore di univocità: questo nome con questa data è già presente nei dati' : $response=$exception->getMessage();
            return back()->withErrors($response);
        }

        return redirect('/policies');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Policy $policy)
    {
        return view('policy.delete')->with('policy', $policy);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Policy $policy)
    {
        $policy->delete();

        return redirect('/policies');
    }
}
