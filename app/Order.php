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
        'canceled' => 'annullato'
    ];

    protected $fillable = ['date','number','status','deliverynote','user_id','company_id','shipping_address_id','total_amount'];
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function shipping_address()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    //
}
