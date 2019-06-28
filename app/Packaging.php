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
        return $this->quantity . ' ' . $this->type . ' x ' . $this->capacity . ' l';
    }

    public function beers()
    {
        return $this->hasMany(Beer::class);
    }

    public function getCapacityAttribute($value)
    {
        return $value / 100;
    }

    public function setCapacityAttribute($value)
    {
        $this->attributes['capacity'] = $value * 100;
    }
}
