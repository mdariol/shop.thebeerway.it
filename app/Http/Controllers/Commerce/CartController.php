<?php

namespace App\Http\Controllers\Commerce;

use App\Beer;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * CartController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('cart.show')->with([
            'cart' => cart(),
        ]);
    }

    /**
     * Add beer to cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $beer = Beer::findOrFail(request()->beer_id);

        cart()->add($beer);

        return back()->with('added', "$beer->name aggiunta al carrello.");
    }

    /**
     * Empty the cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function empty()
    {
        cart()->empty();

        return back();
    }
}
