<?php

namespace App\Http\Controllers\Commerce;

use App\Beer;
use App\Http\Controllers\Controller;
use App\Rules\Available;
use Illuminate\Http\Request;

class CartController extends Controller
{
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $request->validate($this->rules() + [
            'quantity' => ['required', 'min:1', new Available($request->beer_id)],
        ]);

        $beer = Beer::find($request->beer_id);

        cart()->add($beer, $request->quantity);

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

    /**
     * Validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'beer_id' => 'required|exists:beers,id',
        ];
    }
}
