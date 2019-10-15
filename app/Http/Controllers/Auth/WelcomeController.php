<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    /**
     * WelcomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view('welcome')->with(['user' => auth()->user()]);
    }
}
