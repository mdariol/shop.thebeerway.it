<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
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
        return view('lot.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate($this->rules());

        Lot::create($attributes);

        return redirect()->route('admin.lots.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lot  $lot
     * @return \Illuminate\Http\Response
     */
    public function show(Lot $lot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lot  $lot
     * @return \Illuminate\Http\Response
     */
    public function edit(Lot $lot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lot  $lot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lot $lot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lot  $lot
     * @return \Illuminate\Http\Response
     */
    public function delete(Lot $lot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lot  $lot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lot $lot)
    {
        //
    }

    /**
     * Validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'number' => 'required',
            'beer_id' => 'required|exists:beers,id',
            'stock' => 'required|min:0',
            'reserved' => 'required|min:0',
            'bottled_at' => 'nullable|date|before:expires_at',
            'expires_at' => 'required|date',
        ];
    }
}
