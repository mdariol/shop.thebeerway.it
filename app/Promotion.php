<?php

namespace App;

use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\PromotionsScope;

class Promotion extends Model
{
    use HasFilters;

    protected $fillable = [
        'name', 'discount',
        'from_date', 'to_date', 'priority',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PromotionsScope);
    }

    public function promotion_beers()
    {
        return $this->hasMany(PromotionBeer::class);
    }

    public function promotion_breweries()
    {
        return $this->hasMany(PromotionBrewery::class);
    }

    public function promotion_users()
    {
        return $this->hasMany(PromotionUser::class);
    }


    //
}
