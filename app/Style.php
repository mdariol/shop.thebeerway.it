<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $fillable = ['name','area_id'];

    public function beers()
    {
        return $this->hasMany(Beer::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
