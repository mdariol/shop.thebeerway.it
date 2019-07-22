<?php

namespace App;

use App\Scopes\TastesScope;
use Illuminate\Database\Eloquent\Model;

class Taste extends Model
{
    protected $fillable = ['name'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TastesScope);
    }


    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
