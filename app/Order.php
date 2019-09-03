<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrdersScope;

class Order extends Model
{
    const STATUS = [
        'draft' => 'bozza',
        'complete' => 'completato',
        'delivered' => 'consegnato',
        'cancelled' => 'annullato'
    ];

    protected $fillable = ['date','number','status','deliverynote','user_id'];
    //

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrdersScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function lines()
    {
        return $this->hasMany(Line::class);
    }



    //
}
