<?php

namespace App\Http\Controllers;

use App\Packaging;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PackagingController extends Controller
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

        try{
            Packaging::create(request(['type','quantity','capacity'] ));
        } catch(QueryException $exception) {
            $exception->getCode() =='23000' ? $response='Errore di univocità: questo packaging è già presente nei dati' : $response=$exception->getMessage();
            return back()->withErrors($response)->withInput();
        }

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

        try{
            $packaging->update(request(['type','quantity','capacity'] ));
        } catch(QueryException $exception) {
            $exception->getCode() =='23000' ? $response='Errore di univocità: questo packaging è già presente nei dati' : $response=$exception->getMessage();
            return back()->withErrors($response);
        }

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
