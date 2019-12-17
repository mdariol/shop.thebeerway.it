<?php

namespace App\Http\Controllers;

use App\Brewery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BreweryController extends Controller
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
        if (request()->wantsJson()){
            return Brewery::queryFilter()->get();
        }
        return view('brewery.index')->with('breweries', Brewery::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brewery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brewery = Brewery::create(['name' => $request->name, 'website' => $request->website]);

        if (request()->has('logo')) {
            $this->upload('logo', $brewery);
        }

        return redirect('/breweries');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Http\Response
     */
    public function show(Brewery $brewery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Http\Response
     */
    public function edit(Brewery $brewery)
    {
        return view('brewery.edit')->with('brewery', $brewery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brewery $brewery)
    {
        $brewery->update(request(['name','website']) + [
                'isactive' => $request->has('isactive')
            ]);
        if (request()->has('logo')) {
            $this->upload('logo', $brewery);
        }

        return redirect('/breweries');
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Brewery $brewery)
    {
        return view('brewery.delete')->with('brewery', $brewery);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brewery  $brewery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brewery $brewery)
    {

        $brewery->delete();

        return redirect('/breweries');

    }


    protected function upload(string $file, Brewery $brewery)
    {
        request()->validate([$file => ['image', 'max:1024']]);

        if ($brewery->logo) {
            Storage::disk('public')->delete($brewery->logo);
        }

        $name = $brewery->name.'.jpg';

        $file = Image::make(request()->file($file))
            ->encode('jpg', 75);

        Storage::disk('public')->put("brewery_logos/$name", $file);

        $brewery->update(['logo' => "brewery_logos/$name"]);
    }


}
