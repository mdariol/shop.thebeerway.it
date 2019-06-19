<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Middleware\AllowIfAdmin;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Control if is Admin role defined in middleware.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('area.index')->with('areas', Area::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('area.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Area::create(['name' => $request->name]);

        return redirect('/areas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('area.edit')->with('area', $area);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Area $area)
    {
        $area->update(request(['name']));

        return redirect('/areas');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Area $area)
    {
        return view('area.delete')->with('area', $area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();

        return redirect('/areas');
    }
}
