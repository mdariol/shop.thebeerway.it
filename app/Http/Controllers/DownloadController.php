<?php

namespace App\Http\Controllers;

use App\Beer;
use App\Brewery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DownloadController extends Controller
{
    /**
     * Download requested file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(){
        $file = request()->file;

        if ( ! is_file("storage/$file")) {
            abort(404);
        }

        return response()->download("storage/$file");
    }
}
