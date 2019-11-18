<?php

namespace App;

use App\Traits\HasFilters;
use App\Traits\HasState;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\OrdersScope;
use Illuminate\Support\Facades\DB;

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

    /**
     * Calculate order's total amount.
     *
     * @return $this
     */
    public function calcTotalAmount()
    {
        $lines = $this->lines()->select(['unit_price', 'qty'])->get();

        $this->total_amount = array_reduce($lines->toArray(), function ($carry, $line) {
            return $carry + ($line['unit_price'] * $line['qty']);
        }, 0);

        return $this;
    }

    /**
     * Calculate order's number.
     *
     * @return $this
     */
    public function calcNumber()
    {
        if ( ! $this->number) {
            $this->number = DB::table('orders')->max('number') + 1;
        }

        return $this;
    }
}
