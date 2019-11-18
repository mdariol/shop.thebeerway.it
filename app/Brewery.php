<?php

namespace App;

use App\Scopes\BreweriesScope;
use Illuminate\Database\Eloquent\Model;

class Brewery extends Model
{
    protected $fillable = ['name','isactive','logo'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BreweriesScope);
    }


    public function beers()
    {
        return $this->hasMany(Beer::class);
    }

    public function purchaseorders()
    {
        return $this->hasMany(Purchaseorder::class);
    }

    public function promotion_breweries()
    {
        return $this->hasMany(PromotionBrewery::class);
    }


}
