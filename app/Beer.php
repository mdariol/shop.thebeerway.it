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

    protected $with = [
        'packaging', 'style', 'brewery', 'price', 'color','taste',
    ];

    protected $appends = ['in_stock'];

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


    public function brewery()
    {
        return $this->belongsTo(Brewery::class);
    }

    public function packaging()
    {
        return $this->belongsTo(Packaging::class);
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }

    public function price()
    {
        return $this->hasOne(Price::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function taste()
    {
        return $this->belongsTo(Taste::class);
    }

    /**
     * @return bool
     *
     * @deprecated Use getInStockAttribute() instead.
     * @see Beer::getInStockAttribute()
     */
    public function inStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Whether the beer is in stock or not.
     *
     * @return bool
     */
    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }

    public function lines()
    {
        return $this->hasMany(Line::class);
    }


}
