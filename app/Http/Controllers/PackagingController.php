<?php

namespace App\Http\Controllers;

use App\Packaging;
use Illuminate\Http\Request;

class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('packaging.index')->with('packagings', Packaging::all());
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('packaging.create');
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
        Packaging::create(request(['name','quantity','capacity'] )+ [
                'is_bottle' => (bool) request()->get('is_bottle')]);


        return redirect('/packagings');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function show(Packaging $packaging)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function edit(Packaging $packaging)
    {
        return view('packaging.edit')->with([
            'packaging' => $packaging,
            'packagings' => Packaging::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Packaging $packaging)
    {
        $packaging->update(request(['name','quantity','capacity'] )+ [
                'is_bottle' => (bool) request()->get('is_bottle')]);

        return redirect('/packagings');
    }


    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Packaging $packaging)
    {
        return view('packaging.delete')->with('packaging', $packaging);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Packaging  $packaging
     * @return \Illuminate\Http\Response
     */
    public function destroy(Packaging $packaging)
    {
        $packaging->delete();

        return redirect('/packagings');
    }
}
