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
        $this->setUserPrice();
        return $this->attributes['net_price'];
    }

    public function getNetLiterPriceAttribute() : float
    {
        $this->setUserPrice();
        return $this->attributes['net_liter_price'];
    }

    public function getNetUnitPriceAttribute() : float
    {
        $this->setUserPrice();
        return $this->attributes['net_unit_price'];
    }

    public function getDiscountAttribute() : float
    {
        $this->setUserPrice();
        return $this->attributes['discount'];
    }

    protected function setUserPrice() : bool
    {
        if (! array_key_exists('net_price', $this->attributes)){
            $promotion = Promotion::applicable( $this->beer );
            if ($promotion) {
                $discount = $promotion->discount ? $promotion->discount : 0;
                $netprice = number_format($this->distribution - ($this->distribution * $promotion->discount /100),2) ;
            } else
            {
                $discount = 0;
                $netprice = $this->distribution;
            }
            $this->attributes['discount'] = $discount;
            $this->attributes['net_price'] = $netprice;
            $this->attributes['net_liter_price'] = number_format($netprice/$this->beer->packaging->capacity,2);
            $this->attributes['net_unit_price'] = number_format($netprice/$this->beer->packaging->quantity,2);

            return true;
        }
        return false;
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
