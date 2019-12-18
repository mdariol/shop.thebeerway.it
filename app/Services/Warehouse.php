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
     * Create lot.
     *
     * @param  array  $attributes
     * @param  bool  $log
     * @return Collection
     * @throws \Throwable
     */
    public function create(array $attributes, bool $log = true)
    {
        $reserved = $attributes['reserved'] ?? null;

        if ($reserved) unset($attributes['reserved']);

        $lot = Lot::create($attributes);

        if ($log) $movement = new Movement([
            'action' => __FUNCTION__,
            'quantity' => $lot->stock,
        ]);

        DB::transaction(function () use ($lot, $movement) {
            $lot->save();
            $lot->movements()->save($movement);
        });

        $movements = collect($movement);

        if ($reserved) {
            $movements->merge($this->bind(collect([$lot]), $reserved));
        };

        return $movements;
    }

    /**
     * Delete lot.
     *
     * @param  Lot  $lot
     */
    public function delete(Lot $lot)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Increase stock quantity.
     *
     * @param Lot $lot
     * @param  int  $quantity
     * @param  bool  $log
     * @return Collection
     * @throws \Throwable
     */
    public function load(Lot $lot, int $quantity = 1, bool $log = true)
    {
        $lot->stock += $quantity;

        if ($log) $movement = new Movement([
            'action' => __FUNCTION__,
            'quantity' => $lot->stock,
        ]);

        DB::transaction(function () use ($lot, $movement) {
            $lot->save();
            $lot->movements()->save($movement);
        });

        return collect($movement);
    }

    /**
     * Decrease quantity from stock.
     *
     * @param  Collection  $lots
     * @param  int  $quantity
     * @param  bool  $log
     * @return Collection
     * @throws \Throwable
     */
    public function decrease(Collection $lots, int $quantity = 1, bool $log = true)
    {
        // TODO: Remane method unload().

        $movements = [];

        foreach ($lots as $lot) {
            if ($quantity <= $lot->stock) {
                $lot->stock -= $quantity;

                if ($log) array_push($movements, new Movement([
                    'action' => __FUNCTION__,
                    'quantity' => $quantity,
                    'lot_id' => $lot->id,
                ]));

                break;
            }

            if ($log) array_push($movements, new Movement([
                'action' => __FUNCTION__,
                'quantity' => $lot->stock,
                'lot_id' => $lot->id,
            ]));

            $quantity -= $lot->stock;
            $lot->stock = 0;
        }

        DB::transaction(function () use ($lots, $movements) {
            foreach ($lots as $lot) $lot->save();
            foreach ($movements as $movement) $movement->save();
        });

        return collect($movements);
    }

    /**
     * Increase reserved quantity.
     *
     * @param  int  $quantity
     * @param  Collection  $lots
     * @param  bool  $log
     * @return Collection
     * @throws \Throwable
     */
    public function bind(Collection $lots, int $quantity = 1, bool $log = true)
    {
        $movements = [];

        foreach ($lots as $lot) {
            if ($quantity <= $lot->available) {
                $lot->reserved += $quantity;

                if ($log) array_push($movements, new Movement([
                    'action' => __FUNCTION__,
                    'quantity' => $quantity,
                    'lot_id' => $lot->id,
                ]));

                break;
            }

            if ($log) array_push($movements, new Movement([
                'action' => __FUNCTION__,
                'quantity' => $lot->available,
                'lot_id' => $lot->id,
            ]));

            $quantity -= $lot->available;
            $lot->reserved += $lot->available;
        }

        DB::transaction(function () use ($lots, $movements) {
            foreach ($lots as $lot) $lot->save();
            foreach ($movements as $movement) $movement->save();
        });

        return collect($movements);
    }

    /**
     * Decrease reserved quantity.
     *
     * @param  Collection  $lots
     * @param  int  $quantity
     * @param  bool  $log
     * @return Collection
     * @throws \Throwable
     */
    public function unbind(Collection $lots, int $quantity = 1, bool $log = true)
    {
        $movements = [];

        foreach ($lots as $lot) {
            if ($quantity <= $lot->reserved) {
                $lot->reserved -= $quantity;

                if ($log) array_push($movements, new Movement([
                    'action' => __FUNCTION__,
                    'quantity' => $quantity,
                    'lot_id' => $lot->id,
                ]));

                break;
            }

            if ($log) array_push($movements, new Movement([
                'action' => __FUNCTION__,
                'quantity' => $lot->reserved,
                'lot_id' => $lot->id,
            ]));

            $quantity -= $lot->reserved;
            $lot->reserved = 0;
        }

        DB::transaction(function () use ($lots, $movements) {
            foreach ($lots as $lot) $lot->save();
            foreach ($movements as $movement) $movement->save();
        });

        return collect($movements);
    }

    /**
     * Whether the quantity is available on given lots.
     *
     * @param Collection $lots
     * @param int $quantity
     * @return bool
     */
    public function isAvailable(Collection $lots, int $quantity = 1): bool
    {
        return $this->available($lots) >= $quantity;
    }

    /**
     * Whether the quantity is in stock on given lots.
     *
     * @param Collection $lots
     * @param int $quantity
     * @return bool
     */
    public function inStock(Collection $lots, int $quantity = 1): bool
    {
        return $this->stock($lots) >= $quantity;
    }

    /**
     * Count available items on given lots.
     *
     * @param Collection $lots
     * @return int
     */
    public function available(Collection $lots): int
    {
        return $lots->reduce(function($available, $lot) {
            return $available + $lot->available;
        }, 0);
    }

    /**
     * Count in stock items on given lots.
     *
     * @param Collection $lots
     * @return int
     */
    public function stock(Collection $lots): int
    {
        return $lots->reduce(function($stock, $lot) {
            return $stock + $lot->stock;
        }, 0);
    }

    /**
     * Count reserved items on given lots.
     *
     * @param Collection $lots
     * @return int
     */
    public function reserved(Collection $lots): int
    {
        return $lots->reduce(function ($reserved, $lot) {
            return $reserved + $lot->reserved;
        }, 0);
    }
}