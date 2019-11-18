<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionBrewery extends Model
{


    protected $fillable = [
        'promotion_id', 'brewery_id',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function brewery()
    {
        return $this->belongsTo(Brewery::class);
    }


    //
}
