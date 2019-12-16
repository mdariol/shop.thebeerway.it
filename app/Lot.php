<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    public $timestamps = false;

    protected $fillable = ['number', 'beer_id', 'stock', 'reserved', 'bottled_at', 'expires_at'];

    protected $dates = ['bottled_at', 'expires_at'];

    /**
     * Related beer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }

    /**
     * Count of items available to purchase.
     *
     * @return int
     */
    public function getAvailableAttribute(): int
    {
        return $this->stock - $this->reserved;
    }

    /**
     * Whether the quantity is available to purchase or not.
     *
     * @param int $quantity
     * @return bool
     */
    public function isAvailable(int $quantity = 1): bool
    {
        return $this->available > $quantity;
    }

    /**
     * Whether the quantity is in stock or not.
     *
     * @param int $quantity
     * @return bool
     */
    public function inStock(int $quantity = 1): bool
    {
        return $this->stock > $quantity;
    }

    /**
     * Scope a query to only include lots with available items.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->whereRaw('stock - reserved > 0');
    }

    /**
     * Scope a query to only include lots with items in stock.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include lots with reserved items.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeReserved(Builder $query): Builder
    {
        return $query->where('reserved', '>', 0);
    }
}
