<?php

namespace App;

use App\Traits\HasFilters;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\PromotionsScope;
use Illuminate\Support\Facades\DB;

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

    public static function applicable(Beer $beer) {
        $user = auth()->user();
//        $user = User::find(1);
        if (! $user or ! $beer) {
            return;
        }

        $promotionBeer = DB::table('promotions')
            ->join('promotion_beers', 'promotions.id', '=', 'promotion_beers.promotion_id')
            ->where('promotions.from_date','<=' ,  Carbon::today())
            ->where('promotions.to_date','>=' ,  Carbon::today())
            ->where('promotion_beers.beer_id','=' ,  $beer->id);


        $promotionBrewery = DB::table('promotions')
            ->join('promotion_breweries', 'promotions.id', '=', 'promotion_breweries.promotion_id')
            ->where('promotions.from_date','<=' ,  Carbon::today())
            ->where('promotions.to_date','>=' ,  Carbon::today())
            ->where('promotion_breweries.brewery_id','=' ,  $beer->brewery->id);

        return $promotionUser = DB::table('promotions')
            ->join('promotion_users', 'promotions.id', '=', 'promotion_users.promotion_id')
            ->where('promotions.from_date','<=' ,  Carbon::today())
            ->where('promotions.to_date','>=' ,  Carbon::today())
            ->where('promotion_users.user_id','=' ,  $user->id)
            ->union($promotionBrewery)
            ->union($promotionBeer)
            ->orderBy('priority', 'asc')
            ->orderBy('discount', 'desc')
            ->first();
    }

    //
}
