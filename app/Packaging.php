<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    const TYPE = ['bottiglie','lattine','fusti'];
    protected $fillable = ['type','quantity','capacity'];

    public function getNameAttribute(){
        return $this->quantity . ' ' . $this->type . ' x ' . $this->capacity/100 . ' l';
    }


    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
