<?php

namespace App\Exports;

use App\Beer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BeersExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */

    public function view(): View
    {
        return view('beer.pricelist', [
            'beers' => Beer::all()
        ]);

    }
}
