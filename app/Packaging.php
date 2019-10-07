<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    const TYPE = [
        'bottle' => 'bottiglie',
        'can' => 'lattine',
        'barrel' => 'fusti'
    ];

    protected $fillable = ['type','quantity','capacity'];

    public function getNameAttribute(){
        $qty = $this->quantity == 1 ? '' : $this->quantity. ' ';
        return $qty. $this->type . ' da ' . $this->capacity . ' l';
    }

    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
