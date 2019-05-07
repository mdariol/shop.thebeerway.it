<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brewery extends Model
{
    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
