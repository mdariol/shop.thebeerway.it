<?php

namespace App\Http\Controllers;

use App\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    const RULES = [
        'beer_id' => ['required', 'exists:beers,id'],
        'qty' => ['required', 'min:1'],
    ];

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
        $line->update(request()->validate(self::RULES) + [
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
}
