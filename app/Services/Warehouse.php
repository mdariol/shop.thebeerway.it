<?php

namespace App\Services;

use App\Beer;
use Illuminate\Support\Collection;

class Warehouse
{
    /**
     * @param Beer $beer
     * @param int $quantity
     * @param Collection|null $lots
     * @param bool $reserved
     * @return int
     */
    public function decrease(Beer $beer, int $quantity = 1, Collection $lots = null, bool $reserved = true)
    {
        if (is_null($lots)) $lots = $beer->lots;

        $lots->each(function ($lot) use (&$quantity, $reserved) {
            if ($quantity <= $lot->stock) {
                $lot->update([
                    'stock' => $lot->stock - $quantity,
                    'reserved' => $reserved ? $lot->reserved - $quantity : $lot->reserved,
                ]);

                return false;
            }

            $quantity -= $lot->stock;

            $lot->update(['stock' => 0, 'reserved' => 0]);
        });

        return $quantity;
    }

    /**
     * @param Beer $beer
     * @param int $quantity
     * @param Collection|null $lots
     * @return int
     */
    public function bind(Beer $beer, int $quantity = 1, Collection $lots = null)
    {
        if (is_null($lots)) $lots = $beer->lots;

        $lots->each(function ($lot) use (&$quantity) {
            if ($quantity <= $lot->available) {
                $lot->update(['reserved' => $lot->reserved + $quantity]);

                return false;
            }

            $quantity -= $lot->available;

            $lot->update(['reserved' => $lot->reserved + $lot->available]);
        });

        return $quantity;
    }

    /**
     * @param  Beer  $beer
     * @param  int  $quantity
     * @param  Collection|null  $lots
     * @return int
     */
    public function unbind(Beer $beer, int $quantity = 1, Collection $lots = null)
    {
        if (is_null($lots)) $lots = $beer->lots;

        $lots->each(function ($lot) use (&$quantity) {
            if ($quantity <= $lot->reserved) {
                $lot->update(['reserved' => $lot->reserved - $quantity]);
                $quantity = 0;

                return false;
            }

            $quantity -= $lot->reserved;

            $lot->update([$lot->reserved => 0]);
        });

        return $quantity;
    }

    /**
     * @param Beer $beer
     * @param int $quantity
     * @return bool
     */
    public function isAvailable(Beer $beer, int $quantity = 1)
    {
        return $this->available($beer) > $quantity;
    }

    /**
     * @param Beer $beer
     * @param int $quantity
     * @return bool
     */
    public function inStock(Beer $beer, int $quantity = 1)
    {
        return $this->stock($beer) > $quantity;
    }

    /**
     * @param Beer $beer
     * @return int
     */
    public function available(Beer $beer)
    {
        return $beer->lots->reduce(function($available, $lot) {
            return $available + $lot->available;
        }, 0);
    }

    /**
     * @param Beer $beer
     * @return int
     */
    public function stock(Beer $beer)
    {
        return $beer->lots->reduce(function($stock, $lot) {
            return $stock + $lot->stock;
        }, 0);
    }

    /**
     * @param Beer $beer
     * @return int
     */
    public function reserved(Beer $beer)
    {
        return $beer->lots->reduce(function ($reserved, $lot) {
            return $reserved + $lot->reserved;
        }, 0);
    }
}
