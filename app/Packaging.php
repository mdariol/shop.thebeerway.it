<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
