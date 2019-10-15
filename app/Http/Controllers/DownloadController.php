<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Brewery;
use Illuminate\Http\Request;

class ImageDownloadController extends Controller
{

        public function beerImageDownload($beer_id){
            
            return response()->download($pathToFile, $name, $headers);
        }


}
