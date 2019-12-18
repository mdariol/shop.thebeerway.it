<?php

namespace App\Traits;

use App\Lot;

trait HasLots
{
    /**
     * Related lots, ordered by expiration date.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lots()
    {
        return $this->hasMany(Lot::class)->orderBy('expires_at');
    }

    /**
     * Count of items available to purchase.
     *
     * @return int
     */
    public function getAvailableAttribute()
    {
        $lots = $this->lots()->available()->get();

        return warehouse()->available($lots);
    }

    /**
     * Count of items in stock.
     *
     * @return int
     */
    public function getStockAttribute()
    {
        $lots = $this->lots()->inStock()->get();

        return warehouse()->stock($lots);
    }

    /**
     * Count of reserved items.
     *
     * @return int
     */
    public function getReservedAttribute()
    {
        $lots = $this->lots()->reserved()->get();

        return warehouse()->reserved($lots);
    }

    /**
     * Whether the quantity is available to purchase or not.
     *
     * @param int $quantity
     * @return bool
     */
    public function isAvailable(int $quantity = 1)
    {
        $lots = $this->lots()->available()->get();

        return warehouse()->isAvailable($lots, $quantity);
    }

    /**
     * Whether the quantity is in stock or not.
     *
     * @param int $quantity
     * @return bool
     */
    public function inStock(int $quantity = 1)
    {
        $lots = $this->lots()->inStock()->get();

        return warehouse()->inStock($lots, $quantity);
    }
}
