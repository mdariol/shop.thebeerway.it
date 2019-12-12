<?php

namespace App;

use App\Scopes\BeersScope;
use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    use HasFilters;

    protected $fillable = [
        'code', 'name', 'description', 'isactive',
        'abv', 'ibu', 'plato', 'stock', 'taste_id',
        'brewery_id', 'packaging_id', 'color_id',
        'style_id', 'price_id', 'image', 'requested_stock' ,
    ];

    protected $with = ['packaging', 'style', 'brewery', 'price', 'color', 'taste'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BeersScope);
    }


    /**
     * Related brewery.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brewery()
    {
        return $this->belongsTo(Brewery::class);
    }

    /**
     * Related packaging.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function packaging()
    {
        return $this->belongsTo(Packaging::class);
    }

    /**
     * Related style.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function style()
    {
        return $this->belongsTo(Style::class);
    }

    /**
     * Related price.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function price()
    {
        return $this->hasOne(Price::class);
    }

    /**
     * Related color.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Related taste.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taste()
    {
        return $this->belongsTo(Taste::class);
    }

    /**
     * Related lines.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines()
    {
        return $this->hasMany(Line::class);
    }

    /**
     * Related promotions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promotions()
    {
        return $this->belongsToMany(Beer::class, 'promotion_beers')->withTimestamps();
    }

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
        return $this->lots->reduce(function($available, $lot) {
            return $available + $lot->available;
        }, 0);
    }

    /**
     * Count of items in stock.
     *
     * @return int
     */
    public function getStockAttribute()
    {
        return $this->lots->reduce(function($stock, $lot) {
            return $stock + $lot->stock;
        }, 0);
    }

    /**
     * Count of reserved items.
     *
     * @return int
     */
    public function getReservedAttribute()
    {
        return $this->lots->reduce(function ($reserved, $lot) {
            return $reserved + $lot->reserved;
        }, 0);
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
    public function inStock(int $quantity = 1)
    {
        return $this->stock > $quantity;
    }
}
