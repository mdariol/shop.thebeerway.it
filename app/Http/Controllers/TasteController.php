<?php

namespace App\Http\Controllers;

use App\Taste;
use Illuminate\Http\Request;

class TasteController extends Controller
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
        return view('taste.index')->with('tastes', Taste::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taste.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Taste::create(['name' => $request->name]);

        return redirect('/tastes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\taste  $taste
     * @return \Illuminate\Http\Response
     */
    public function show(taste $taste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\taste  $taste
     * @return \Illuminate\Http\Response
     */
    public function edit(taste $taste)
    {
        return view('taste.edit')->with('taste', $taste);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\taste  $taste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, taste $taste)
    {
        $taste->update(request(['name']));

        return redirect('/tastes');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Taste  $taste
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Taste $taste)
    {
        return view('taste.delete')->with('taste', $taste);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\taste  $taste
     * @return \Illuminate\Http\Response
     */
    public function destroy(taste $taste)
    {
        $taste->delete();

        return redirect('/tastes');
    }
}
