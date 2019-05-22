<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'horeca', 'horeca_unit', 'discount',
        'purchase', 'purchase_unit',
        'distribution', 'distribution_unit',
        'margin', 'fixed_margin'
    ];

    public function beer()
    {
        return $this->hasOne(Beer::class);
    }
}
