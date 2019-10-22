<?php

namespace App;

use App\Traits\HasFilters;
use App\Traits\HasState;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrdersScope;

class Order extends Model
{
    use HasFilters;
    use HasState;

    const WORKFLOW = 'orderflow';

    protected $fillable = [
        'date', 'number', 'state', 'deliverynote', 'user_id',
        'billing_profile_id', 'shipping_address_id', 'policy_id',
        'policy_accept', 'total_amount',
    ];

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

    public function billing_profile()
    {
        return $this->belongsTo(BillingProfile::class);
    }

    public function shipping_address()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }
}
