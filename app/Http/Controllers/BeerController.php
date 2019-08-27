<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Brewery;
use App\Color;
use App\Packaging;
use App\Style;
use App\Taste;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use App\Cart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class BeerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['index', 'show','getAddToCart','getCart','fixupCart','fixdownCart']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beers = Beer::queryFilter()
            ->join('breweries', 'beers.brewery_id', '=', 'breweries.id' )
            ->leftJoin('styles', 'beers.style_id', '=', 'styles.id' )
            ->select('beers.*', 'breweries.name as brewery_name', 'styles.name as style_name')
            ->orderBy('brewery_name', 'ASC')
            ->orderBy('style_name', 'ASC')
            ->get();

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
//        dd(request()->getRequestUri());

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
        ]
        );


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

    public function getAddToCart(Request $request, Beer $beer){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($beer, $beer->id);

        $addedBeer = $beer->getRelation('packaging')->getAttribute('name').', '.$beer->getAttribute('name').' di '.$beer->getRelation('brewery')->getAttribute('name') ;
        $request->session()->put('cart', $cart);

       return back()->with('success', $addedBeer.' aggiunto al carrello');

    }

    public function fixupCart(Request $request, Beer $beer){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $id = $beer->id;

        if (array_key_exists($id, $cart->items)) {
            $storedItem = $cart->items[$id];
        }

        $storedItem['qty']++;
        $storedItem['price'] = $storedItem['unit_price'] * $storedItem['qty'];

        $cart->items[$id] = $storedItem;

        $cart->totalQty++;
        $cart->totalPrice+= $storedItem['unit_price'];
        $request->session()->put('cart', $cart);
        return back();
    }

    public function fixdownCart(Request $request, Beer $beer){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        $id = $beer->id;


        if (array_key_exists($id, $cart->items)) {
            $storedItem = $cart->items[$id];
        }

        $storedItem['qty']--;
        $storedItem['price'] = $storedItem['unit_price'] * $storedItem['qty'];


        $cart->items[$id] = $storedItem;

        $cart->totalQty--;
        $cart->totalPrice-= $storedItem['unit_price'];
        $request->session()->put('cart', $cart);
        return back();
    }


    public function getCart(){
//        dd(Session::get('cart'));
        if (!Session::has('cart')){
            return view('beer.shoppingcart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('beer.shoppingcart',['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);

    }



}
