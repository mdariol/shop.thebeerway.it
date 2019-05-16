<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    protected $fillable = ['is_bottle','name','quantity','capacity'];

    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
