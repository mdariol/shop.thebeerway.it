<?php

namespace App;

use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Model;

class Beer extends Model
{
    use HasFilters;

    protected $fillable = [
        'code', 'name', 'description',
        'abv', 'ibu', 'plato', 'stock',
        'brewery_id', 'packaging_id',
        'style_id', 'price_id', 'color_id','taste_id','isactive'
    ];

    protected $with = [
        'packaging', 'style', 'brewery', 'price', 'color','taste',
    ];

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
    public function inStock(): bool
    {
        return $this->stock > 0;
    }
}
