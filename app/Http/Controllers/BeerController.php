<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Brewery;
use App\Color;
use App\Exports\BeersExport;
use App\Packaging;
use App\Style;
use App\Taste;
use App\Price;
use http\Client\Request;
use Maatwebsite\Excel\Facades\Excel;

class BeerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['index', 'show','getAddToCart','getCart','fixupCart','fixdownCart', 'savedeliverynote','saveOrder']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beers = Beer::queryFilter()
            ->leftJoin('breweries', 'beers.brewery_id', '=', 'breweries.id' )
            ->leftJoin('styles', 'beers.style_id', '=', 'styles.id' )
            ->leftJoin('packagings', 'beers.packaging_id', '=', 'packagings.id' )
            ->select('beers.*', 'breweries.name as brewery_name', 'styles.name as style_name')
            ->orderBy('brewery_name', 'ASC')
            ->orderBy('style_name', 'ASC')
            ->get();

        $filtered = $beers->filter(function ($beer) {
            if ($beer->price->net_price <> $beer->price->distribution){
                return $beer;
            }
        });

        if (request()->has('onsale')) {
            $beers = $filtered;
        }

        if (request()->wantsJson()) {
            return $beers;
        }

        activity()
          ->causedBy(request()->user())
          ->withProperties(request()->all())
          ->log('Beer search');

        return view('beer.index')->with([
            'beers' => $beers,
            'styles' => Style::all(),
            'breweries' => Brewery::all(),
            'colors' => Color::all(),
            'tastes' => Taste::all(),
            'offers' => $filtered->count(),
            'count' => $beers->count(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function beersdatapricing()
    {

        $beers = Beer::queryFilter()
            ->join('breweries', 'beers.brewery_id', '=', 'breweries.id' )
            ->leftJoin('styles', 'beers.style_id', '=', 'styles.id' )
            ->select('beers.*', 'breweries.name as brewery_name', 'styles.name as style_name')
            ->orderBy('brewery_name', 'ASC')
            ->orderBy('style_name', 'ASC')
            ->get();

        return view('beer.datapricing')->with([
            'beers' => $beers,
            'styles' => Style::all(),
            'breweries' => Brewery::all(),
            'colors' => Color::all(),
            'tastes' => Taste::all(),
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function beerspricelist()
    {

        $beers = Beer::queryFilter()
            ->join('breweries', 'beers.brewery_id', '=', 'breweries.id' )
            ->leftJoin('styles', 'beers.style_id', '=', 'styles.id' )
            ->select('beers.*', 'breweries.name as brewery_name', 'styles.name as style_name')
            ->orderBy('brewery_name', 'ASC')
            ->orderBy('style_name', 'ASC')
            ->get();

        return view('beer.pricelist')->with([
            'beers' => $beers,
            'styles' => Style::all(),
            'breweries' => Brewery::all(),
            'colors' => Color::all(),
            'tastes' => Taste::all(),
        ]);
    }

    public function export()
    {
        return Excel::download(new BeersExport, 'beers.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Beer $beer )
    {
        return view('beer.create')->with([
            'packagings' => Packaging::all(),
            'styles' => Style::all(),
            'breweries' => Brewery::all(),
            'colors' => Color::all(),
            'tastes' => Taste::all(),
            'beer' => $beer,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Beer $beer )
    {
        return view('beer.create')->with([
            'packagings' => Packaging::all(),
            'styles' => Style::all(),
            'breweries' => Brewery::all(),
            'colors' => Color::all(),
            'tastes' => Taste::all(),
            'beer' => $beer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'brewery_id'=>['required'],
            'packaging_id'=>['required']
        ]);

        $beer = Beer::create(request([
            'code', 'name', 'description',
            'abv', 'ibu', 'plato', 'stock',
            'brewery_id', 'packaging_id',
            'style_id', 'color_id', 'taste_id'
        ]) + [
            'isactive' => request()->has('isactive')
        ]);

        $beer->price()->create(request([
            'horeca', 'horeca_unit', 'discount',
            'purchase', 'purchase_unit',
            'distribution', 'distribution_unit', 'margin'
        ]) + [
            'fixed_margin' => request()->has('fixed_margin')
        ]);

        return redirect(request()->getRequestUri());

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
        request()->validate([
            'brewery_id'=>['required'],
            'packaging_id'=>['required']
            ]);

        $beer->price()->updateOrCreate(['beer_id' => $beer->id], request([
            'horeca', 'horeca_unit', 'discount',
            'purchase', 'purchase_unit',
            'distribution', 'distribution_unit', 'margin'
        ]) + [
            'fixed_margin' => request()->has('fixed_margin') ? true : false
        ]);

        $filePath = $beer->image;
        if (request()->has('image')) {
            // Get image file
            $filePath = request()->file('image')->storeas('beers_images', request()->code.'.'.request()->file('image')->getClientOriginalExtension(), 'public');
        }

        $beer->update(request([
            'code', 'name', 'description', 'color_id',
            'abv', 'ibu', 'plato', 'stock', 'taste_id',
            'brewery_id', 'packaging_id', 'style_id'
        ])+ [
            'isactive' => request()->has('isactive'),
            'image'=>$filePath
        ]);

        return redirect(str_replace('/'.$beer->id.'?','?',request()->getRequestUri()));
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

        return redirect(str_replace('/'.$beer->id.'?','?',request()->getRequestUri()));
    }
}
