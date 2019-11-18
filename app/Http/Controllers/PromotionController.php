<?php

namespace App\Http\Controllers;

use App\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
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
        return view('promotion.index')->with('promotions', Promotion::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('promotion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
            'name'=>['required'],
            'discount'=>['required'],
            'from_date'=>['required'],
            'to_date'=>['required'],
        ]);

        $promotion = Promotion::create(request([
                'name', 'discount',
                'from_date', 'to_date', 'priority'
            ]));

        return redirect('/promotions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        return view('promotion.edit')->with('promotion', $promotion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        request()->validate([
            'name'=>['required'],
            'discount'=>['required'],
            'from_date'=>['required'],
            'to_date'=>['required'],
        ]);

        $promotion->update(request([
                'name', 'discount', 'from_date', 'to_date',
                'priority',
            ]));

        return redirect('/promotions');

    }



    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Promotion $promotion)
    {
        return view('promotion.delete')->with('promotion', $promotion);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect('/promotions');
    }
}
