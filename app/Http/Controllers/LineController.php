<?php

namespace App\Http\Controllers;

use App\Line;
use App\Promotion;
use App\Rules\InStock;
use Illuminate\Http\Request;

class LineController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function edit(Line $line)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Line $line)
    {

        $promotion = Promotion::applicable($line->beer);

        $net_price = $promotion->discount ? $line->beer->price->distribution - ($line->beer->price->distribution * $promotion->discount /100) : $line->beer->price->distribution;


        $line->update(request()->validate($this->rules()) + [
            'gross_price' => $line->beer->price->distribution,
            'discount' => $promotion ? $promotion->discount : null,
            'promotion_id' => $promotion ? $promotion->promotion_id : null,
            'unit_price' => $net_price,
            'price' => $request->qty * $net_price,
        ]);

        if ($request->wantsJson()) {
            return $line;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function destroy(Line $line)
    {
        $bool = $line->delete();

        if (\request()->wantsJson()) {
            return ['deleted' => $bool];
        }
    }

    /**
     * Validation rules.
     */
    protected function rules()
    {
        return [
            'beer_id' => ['required', 'exists:beers,id'],
            'qty' => ['required', 'min:1', new InStock(request()->beer_id)],
        ];
    }
}
