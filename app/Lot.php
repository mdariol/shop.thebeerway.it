<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    public $timestamps = false;

    protected $fillable = ['number', 'beer_id', 'stock', 'reserved', 'bottled_at', 'expires_at'];

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

    /**
     * @param Beer $beer
     * @param int $quantity
     */
    public static function reserve(Beer $beer, int $quantity = 1)
    {
        $lots = self::where('beer_id', $beer->id)->orderBy('expires_at')->get();

        $lots->each(function ($lot) use (&$quantity) {
            if ($quantity <= $lot->available) {
                $lot->update([
                    'reserved' => $lot->reserved + $quantity,
                ]);

                return false;
            }

            $quantity -= $lot->available;

            $lot->update([
                'reserved' => $lot->reserved + $lot->available,
            ]);
        });
    }
}
