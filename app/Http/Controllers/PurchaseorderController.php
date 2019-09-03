<?php

namespace App\Http\Controllers;

use App\Brewery;
use App\Purchaseorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PurchaseorderController extends Controller
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
        return view('purchaseorder.index')->with('purchaseorders', Purchaseorder::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchaseorder.create')->with('breweries', Brewery::all());
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


        $new_number = DB::table('purchaseorders')->max('number') + 1;
        if (request()->number > 0 ) {
            $new_number = request()->number;
        } else {
            $new_number = DB::table('purchaseorders')->max('number') + 1;
        }
        Purchaseorder::create(request(['date','brewery_id']) + [
        'number' => $new_number
        ]);

        return redirect('/purchaseorders');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchaseorder  $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function show(Purchaseorder $purchaseorder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchaseorder  $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchaseorder $purchaseorder)
    {
        return view('purchaseorder.edit')->with([
            'purchaseorder' => $purchaseorder,
            'breweries' => Brewery::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchaseorder  $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchaseorder $purchaseorder)
    {
        $purchaseorder->update(request(['number', 'date', 'brewery_id']));

        return redirect('/purchaseorders');
    }


    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Purchaseorder  $purchaseorder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Purchaseorder $purchaseorder)
    {
        return view('purchaseorder.delete')->with('purchaseorder', $purchaseorder);
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchaseorder  $purchaseorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchaseorder $purchaseorder)
    {
        $purchaseorder->delete();

        return redirect('/purchaseorders');
        //
    }
}
