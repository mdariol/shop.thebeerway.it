<?php

namespace App;

use App\Scopes\BeersScope;
use App\Traits\HasFilters;
use App\Traits\HasLots;
use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    use HasFilters;
    use HasLots;

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
}
