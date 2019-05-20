<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    const TYPE = ['bottiglie','lattine','fusti'];
    protected $fillable = ['type','quantity','capacity'];

    public function getNameAttribute(){
        return $this->type.' '.$this->quantity.'x'.$this->capacity/100;
    }


    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
