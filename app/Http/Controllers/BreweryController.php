<?php

namespace App\Http\Controllers;

use App\Brewery;
use Illuminate\Http\Request;

class BreweryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brewery.index')->with('breweries', Brewery::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brewery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Brewery::create(['name' => $request->name]);

        return redirect('/breweries');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Http\Response
     */
    public function show(Brewery $brewery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Http\Response
     */
    public function edit(Brewery $brewery)
    {
        return view('brewery.edit')->with('brewery', $brewery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brewery $brewery)
    {
        $brewery->update(request(['name']));

        return redirect('/breweries');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Brewery $brewery)
    {
        return view('brewery.delete')->with('brewery', $brewery);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brewery $brewery)
    {

        $brewery->delete();

        return redirect('/breweries');

    }
}
