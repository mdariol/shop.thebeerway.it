<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    protected $fillable = ['beer_id', 'qty', 'unit_price', 'price', 'order_id'];

    protected $with = ['beer'];

    protected $dispatchesEvents = [
        'created' => \App\Events\LineChanged::class,
        'updated' => \App\Events\LineChanged::class,
        'deleted' => \App\Events\LineChanged::class,
    ];

    /**
     * Get related beer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function beer()
    {
        return $this->belongsTo(Beer::class);
    }

    /**
     * Get related order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
