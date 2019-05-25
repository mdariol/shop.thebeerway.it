<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'horeca', 'horeca_unit', 'discount',
        'purchase', 'purchase_unit',
        'distribution', 'distribution_unit',
        'margin', 'fixed_margin', 'beer_id',
    ];

    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }
}
