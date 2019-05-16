<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    protected $fillable = ['code', 'name', 'description', 'abv', 'ibu', 'plato',
      'brewery_id', 'packaging_id', 'style_id'];

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
}
