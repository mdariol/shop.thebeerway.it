<?php

namespace App\Http\Controllers;

use App\Brewery;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with('breweries', Brewery::all());
    }
}
