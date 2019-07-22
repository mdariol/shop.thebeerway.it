<?php

namespace App;

use App\Scopes\ColorsScope;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
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

        static::addGlobalScope(new ColorsScope);
    }

    public function beers()
    {
        return $this->hasMany(Beer::class);
    }
}
