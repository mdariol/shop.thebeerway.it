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

    public function beers()
    {
        return $this->belongsToMany(Beer::class, 'promotion_beers')->withTimestamps();
    }

    public function breweries()
    {
        return $this->belongsToMany(Brewery::class, 'promotion_breweries')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'promotion_users')->withTimestamps();
    }


    //
}
