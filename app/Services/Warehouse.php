<?php

namespace App\Services;

use App\Beer;
use App\Lot;
use App\Movement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Warehouse
{
    /**
     * Increase stock quantity.
     *
     * @param  array  $attributes
     * @return Collection
     * @throws \Throwable
     */
    public function load(array $attributes)
    {
        /** @var Lot $lot */
        $lot = new Lot($attributes);
        $movements = [];

        array_push($movements, new Movement([
            'action' => __FUNCTION__,
            'quantity' => $lot->stock,
        ]));

        if ($lot->reserved) {
            array_push($movements, new Movement([
                'action' => 'bind',
                'quantity' => $lot->reserved,
            ]));
        }

        DB::transaction(function () use ($lot, $movements) {
            $lot->save();
            $lot->movements()->saveMany($movements);
        });

        return collect($movements);
    }

    /**
     * Decrease quantity from stock.
     *
     * @param Beer $beer
     * @param int $quantity
     * @param Collection|null $lots
     * @param bool $reserved
     * @return int
     */
    public function decrease(Beer $beer, int $quantity = 1, Collection $lots = null, bool $reserved = true)
    {
        // TODO: Remane method unload().

        if (is_null($lots)) $lots = $beer->lots()->inStock()->get();

        $lots->each(function ($lot) use (&$quantity, $reserved) {
            if ($quantity <= $lot->stock) {
                $lot->update([
                    'stock' => $lot->stock - $quantity,
                    'reserved' => $reserved ? $lot->reserved - $quantity : $lot->reserved,
                ]);

                $quantity = 0;

                return false;
            }

            $quantity -= $lot->stock;

            $lot->update(['stock' => 0, 'reserved' => 0]);
        });

        return $quantity;
    }

    /**
     * Increase reserved quantity.
     *
     * @param Beer $beer
     * @param int $quantity
     * @param Collection|null $lots
     * @return int
     */
    public function bind(Beer $beer, int $quantity = 1, Collection $lots = null)
    {
        if (is_null($lots)) $lots = $beer->lots()->available()->get();

        $lots->each(function ($lot) use (&$quantity) {
            if ($quantity <= $lot->available) {
                $lot->update(['reserved' => $lot->reserved + $quantity]);

                $quantity = 0;

                return false;
            }

            $quantity -= $lot->available;

            $lot->update(['reserved' => $lot->reserved + $lot->available]);
        });

        return $quantity;
    }

    /**
     * Decrease reserved quantity.
     *
     * @param  Beer  $beer
     * @param  int  $quantity
     * @param  Collection|null  $lots
     * @return int
     */
    public function unbind(Beer $beer, int $quantity = 1, Collection $lots = null)
    {
        if (is_null($lots)) $lots = $beer->lots()->reserved()->get();

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
        return $this->available($beer) >= $quantity;
    }

    /**
     * @param Beer $beer
     * @param int $quantity
     * @return bool
     */
    public function inStock(Beer $beer, int $quantity = 1)
    {
        return $this->stock($beer) >= $quantity;
    }

    /**
     * @param Beer $beer
     * @return int
     */
    public function available(Beer $beer)
    {
        $lots = $beer->lots()->available()->get();

        return $lots->reduce(function($available, $lot) {
            return $available + $lot->available;
        }, 0);
    }

    /**
     * @param Beer $beer
     * @return int
     */
    public function stock(Beer $beer)
    {
        $lots = $beer->lots()->inStock()->get();

        return $lots->reduce(function($stock, $lot) {
            return $stock + $lot->stock;
        }, 0);
    }

    /**
     * @param Beer $beer
     * @return int
     */
    public function reserved(Beer $beer)
    {
        $lots = $beer->lots()->reserved()->get();

        return $lots->reduce(function ($reserved, $lot) {
            return $reserved + $lot->reserved;
        }, 0);
    }
}
