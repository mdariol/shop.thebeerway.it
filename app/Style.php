<?php

namespace App;

use App\Scopes\StylesScope;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $fillable = ['name','area_id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StylesScope);
    }

    public function beers()
    {
        return $this->hasMany(Beer::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
