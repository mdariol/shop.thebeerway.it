<?php

namespace App\Http\Controllers;

use App\Area;
use App\Style;

class StyleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('style.index')->with('styles', Style::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('style.create')->with('areas', Area::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        Style::create(request(['name','area_id']));

        return redirect('/styles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Style  $style
     * @return \Illuminate\Http\Response
     */
    public function show(Style $style)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Style  $style
     * @return \Illuminate\Http\Response
     */
    public function edit(Style $style)
    {
        return view('style.edit')->with([
            'style' => $style,
            'areas' => Area::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Style  $style
     * @return \Illuminate\Http\Response
     */
    public function update(Style $style)
    {
        $style->update(request(['name', 'area_id']));

        return redirect('/styles');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Style  $style
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Style $style)
    {
        return view('style.delete')->with('style', $style);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Style  $style
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Style $style)
    {
        $style->delete();

        return redirect('/styles');
    }
}
