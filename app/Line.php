<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = [
        'beer_id', 'qty', 'unit_price', 'price', 'order_id'
    ];

    protected $with = [
        'beer', 'order'
    ];


    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }




}
