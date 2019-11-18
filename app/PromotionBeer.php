<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionBeer extends Model
{
    protected $fillable = [
        'promotion_id', 'beer_id',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }

    //
}
