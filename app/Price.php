<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'purchase','distribution', 'horeca',
        'discount', 'margin', 'fixed_margin', 'beer_id',
    ];

//    protected $appends = [
//        'purchase_unit', 'distribution_unit', 'horeca_unit',
//        'purchase_liter', 'distribution_liter', 'horeca_liter',
//    ];

    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }

    /* ======================================================================
     * Prices
     * ====================================================================== */

    public function setPurchaseAttribute($value)
    {
        $this->attributes['purchase'] = $value * 100;
    }

    public function setDistributionAttribute($value)
    {
        $this->attributes['distribution'] = $value * 100;
    }

    public function setHorecaAttribute($value)
    {
        $this->attributes['horeca'] = $value * 100;
    }

    public function getPurchaseAttribute($value): float
    {
        return round($value / 100, 2);
    }

    public function getDistributionAttribute($value): float
    {
        return round($value / 100, 2);
    }

    public function getHorecaAttribute($value): float
    {
        return round($value / 100, 2);
    }

    /* ----- Price per unit ----- */

    public function getPurchaseUnitAttribute(): float
    {
        return $this->getUnitPrice($this->purchase);
    }

    public function getDistributionUnitAttribute(): float
    {
        return $this->getUnitPrice($this->distribution);
    }

    public function getHorecaUnitAttribute(): float
    {
        return $this->getUnitPrice($this->horeca);
    }

    /* ----- Price per liter ----- */

    public function getPurchaseLiterAttribute(): float
    {
        return $this->getLiterPrice($this->purchase);
    }

    public function getDistributionLiterAttribute(): float
    {
        return $this->getLiterPrice($this->distribution);
    }

    public function getHorecaLiterAttribute(): float
    {
        return $this->getLiterPrice($this->horeca);
    }

    /* ======================================================================
     * Helpers
     * ====================================================================== */

    protected function getPrice($price): float
    {
        return round($price / 100, 2);
    }

    protected function getLiterPrice($price): float
    {
        return round($price / $this->beer->packaging->capacity, 2);
    }

    protected function getUnitPrice($price): float
    {
        return round($price / $this->beer->packaging->quantity, 2);
    }
}
