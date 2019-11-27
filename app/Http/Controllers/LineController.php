<?php

namespace App\Http\Controllers;

use App\Line;
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
        $line->update(request()->validate($this->rules()) + [
            'unit_price' => $line->beer->price->distribution,
            'price' => $request->qty * $line->beer->price->distribution,
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
