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

//    protected $appends = ['net_price','net_liter_price','net_unit_price'];


    public function beer()
    {
        return $this->belongsTo(Beer::class);
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

    public function getNetPriceAttribute() : float
    {
        if (array_key_exists('net_price', $this->attributes)){
            return $this->attributes['net_price'];
        }
        return number_format($this->distribution - ($this->distribution * $this->price_discount /100),2) ;
    }

    public function getNetLiterPriceAttribute() : float
    {
        if (array_key_exists('net_liter_price', $this->attributes)){
            return $this->attributes['net_liter_price'];
        }
        return number_format($this->net_price/$this->beer->packaging->capacity,2);
    }

    public function getNetUnitPriceAttribute() : float
    {
        if (array_key_exists('net_unit_price', $this->attributes)){
            return $this->attributes['net_unit_price'];
        }
        return number_format($this->net_price/$this->beer->packaging->quantity,2);
    }

    public function getPriceDiscountAttribute()
    {
        if (array_key_exists('price_discount', $this->attributes)){
            return $this->attributes['price_discount'];
        }
        $promotion = Promotion::applicable( $this->beer );
        if (!$promotion) {
            return $this->attributes['price_discount'] = 0;
        }
        return $this->attributes['price_discount'] = $promotion->discount ? $promotion->discount : 0;
    }

    /* ----- Helpers ----- */

    protected function getLiterPrice($price): float
    {
        return round($price / $this->beer->packaging->capacity, 2);
    }

    protected function getUnitPrice($price): float
    {
        return round($price / $this->beer->packaging->quantity, 2);
    }
}
