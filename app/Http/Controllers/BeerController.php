<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Brewery;
use App\Color;
use App\Packaging;
use App\Style;
use App\Taste;

class BeerController extends Controller
{
    /**
     * Control if is Admin role defined in middleware.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beers = Beer::queryFilter()->get();

        return view('beer.index')->with([
            'beers' => $beers,
            'styles' => Style::all(),
            'breweries' => Brewery::all(),
            'colors' => Color::all(),
            'tastes' => Taste::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('beer.create')->with([
            'packagings' => Packaging::all(),
            'styles' => Style::all(),
            'breweries' => Brewery::all(),
            'colors' => Color::all(),
            'tastes' => Taste::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $beer = Beer::create(request([
            'code', 'name', 'description',
            'abv', 'ibu', 'plato', 'stock',
            'brewery_id', 'packaging_id',
            'style_id',
        ]));

        $beer->price()->create(request([
            'horeca', 'horeca_unit', 'discount',
            'purchase', 'purchase_unit',
            'distribution', 'distribution_unit', 'margin'
        ]) + [
            'fixed_margin' => request()->has('fixed_margin') ? true : false
        ]);

        return redirect('beers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Beer  $beer
     * @return \Illuminate\Http\Response
     */
    public function show(Beer $beer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Beer  $beer
     * @return \Illuminate\Http\Response
     */
    public function edit(Beer $beer)
    {
        return view('beer.edit')->with([
            'beer' => $beer,
            'breweries' => Brewery::all(),
            'styles' => Style::all(),
            'packagings' => Packaging::all(),
            'colors' => Color::all(),
            'tastes' => Taste::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Beer  $beer
     * @return \Illuminate\Http\Response
     */
    public function update(Beer $beer)
    {
        $beer->price()->updateOrCreate(['beer_id' => $beer->id], request([
            'horeca', 'horeca_unit', 'discount',
            'purchase', 'purchase_unit',
            'distribution', 'distribution_unit', 'margin'
        ]) + [
            'fixed_margin' => request()->has('fixed_margin') ? true : false
        ]);

        $beer->update(request([
            'code', 'name', 'description',
            'abv', 'ibu', 'plato', 'stock',
            'brewery_id', 'packaging_id', 'style_id'
        ]));

        return redirect('/beers');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Beer  $beer
     * @return \Illuminate\Http\Response
     */
    public function delete(Beer $beer)
    {
        return view('beer.delete')->with('beer', $beer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Beer  $beer
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Beer $beer)
    {
        $beer->delete();

        return redirect('/beers');
    }
}
