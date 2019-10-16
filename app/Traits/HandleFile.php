<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandleFile
{
    /**
     * Handle file upload on specified resource.
     *
     * @param  string  $file
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return bool
     *
     * @see resources/js/components/InputImage.vue
     */
    protected function handleFile(string $file, Model $model)
    {
        $delete_file = "delete_$file";

        if ( ! request()->hasFile($file)
            && ! request()->has($delete_file)) return false;

        if (request()->$delete_file) {
            Storage::disk('public')->delete($model->$file);

            return $model->update([$file => null]);
        }

        Storage::disk('public')->delete($model->$file);

        // if (is_callable($callback)) return call_user_func($callback);

        $path = request()->$file->store(Str::plural($file), 'public');

        return $model->update([$file => $path]);
    }
}
