<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    public $timestamps = false;

    protected $fillable = ['stock', 'reserved', 'bottled_at', 'expires_at'];

    protected $dates = ['bottled_at', 'expires_at'];

    /**
     * Count of items available to purchase.
     *
     * @return int
     */
    public function getAvailableAttribute()
    {
        return $this->stock - $this->reserved;
    }

    /**
     * Whether the quantity is available to purchase or not.
     *
     * @param int $quantity
     * @return bool
     */
    public function isAvailable(int $quantity = 1)
    {
        return $this->available > $quantity;
    }

    /**
     * Whether the quantity is in stock or not.
     *
     * @param int $quantity
     * @return bool
     */
    public function inStock(int $quantity = 1) {
        return $this->stock > $quantity;
    }
}
