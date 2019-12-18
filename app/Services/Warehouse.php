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
     * @param  Beer  $beer
     * @param  int  $quantity
     * @param  Collection|null  $lots
     * @param  bool  $reserved
     * @return Collection
     * @throws \Throwable
     */
    public function decrease(Beer $beer, int $quantity = 1, Collection $lots = null, bool $reserved = true)
    {
        // TODO: Remane method unload().

        if (is_null($lots)) $lots = $beer->lots()->inStock()->get();

        $updatedLots = [];
        $movements = [];

        $lots->each(function ($lot) use (&$quantity, $reserved, &$movements, &$updatedLots) {
            if ($quantity <= $lot->stock) {
                $lot->stock -= $quantity;
                if ($reserved) $lot->reserved -= $quantity;

                array_push($updatedLots, $lot);

                array_push($movements, new Movement([
                    'action' => __FUNCTION__,
                    'quantity' => $quantity,
                    'lot_id' => $lot->id,
                ]));

                return false;
            }

            $lot->stock = 0;
            $lot->reserved = 0;

            array_push($updatedLots, $lot);

            array_push($movements, new Movement([
                'action' => __FUNCTION__,
                'quantity' => $quantity,
                'lot_id' => $lot->id,
            ]));

            $quantity -= $lot->stock;
        });

        DB::transaction(function () use ($lots, $movements) {
            foreach ($lots as $lot) { $lot->save(); }
            foreach ($movements as $movement) { $movement->save(); }
        });

        return collect($movements);
    }

    /**
     * Increase reserved quantity.
     *
     * @param  Beer  $beer
     * @param  int  $quantity
     * @param  Collection|null  $lots
     * @return Collection
     * @throws \Throwable
     */
    public function bind(Beer $beer, int $quantity = 1, Collection $lots = null)
    {
        if (is_null($lots)) $lots = $beer->lots()->available()->get();

        $movements = [];
        $updatedLots= [];

        $lots->each(function ($lot) use (&$quantity, &$movements, &$updatedLots) {
            if ($quantity <= $lot->available) {
                $lot->reserved += $quantity;

                array_push($movements, new Movement([
                    'action' => __FUNCTION__,
                    'quantity' => $quantity,
                    'lot_id' => $lot->id,
                ]));

                array_push($updatedLots, $lot);

                return false;
            }

            $quantity -= $lot->available;

            array_push($movements, new Movement([
                'action' => __FUNCTION__,
                'quantity' => $lot->available,
                'lot_id' => $lot->id,
            ]));

            $lot->reserved += $lot->available;

            array_push($updatedLots, $lot);
        });

        DB::transaction(function () use ($movements, $updatedLots) {
            foreach ($updatedLots as $lot) { $lot->save(); }
            foreach ($movements as $movement) { $movement->save(); }
        });

        return collect($movements);
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

        $updatedLots = [];
        $movements = [];

        $lots->each(function ($lot) use (&$quantity, &$updatedLots, &$movements) {
            if ($quantity <= $lot->reserved) {
//                $lot->update(['reserved' => $lot->reserved - $quantity]);

                $lot->reserved -= $quantity;

                array_push($updatedLots, $lot);

                array_push($movements, new Movement([
                    'action' => __FUNCTION__,
                    'quantity' => $quantity,
                    'lot_id' => $lot->id,
                ]));

                return false;
            }

            $quantity -= $lot->reserved;

            array_push($movements, new Movement([
                'action' => __FUNCTION__,
                'quantity' => $lot->reserved,
                'lot_id' => $lot->id,
            ]));

            $lot->reserved = 0;

            array_push($updatedLots, $lot);

//            $lot->update([$lot->reserved => 0]);
        });

        DB::transaction(function () use ($movements, $updatedLots) {
            foreach ($movements as $movement) { $movement->save(); }
            foreach ($updatedLots as $lot) { $lot->save(); }
        });

        return collect($movements);
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
