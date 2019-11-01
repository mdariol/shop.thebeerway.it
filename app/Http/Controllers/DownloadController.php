<?php

namespace App\Http\Controllers;

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
