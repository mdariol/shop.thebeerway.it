<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    public function beers()
    {
        return $this->hasMany(Beer::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
