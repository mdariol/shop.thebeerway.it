<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name'];

    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
