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

    protected $attributes = ['state' => 'draft'];

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

    /**
     * Create a new order with attached lines.
     *
     * @param  array  $attributes
     * @return mixed
     * @throws \Throwable
     */
    public static function createWithLines(array $attributes)
    {
        $order = DB::transaction(function () use ($attributes) {
            $order = self::create($attributes);

            foreach ($attributes['lines'] as $line) {
                Line::create($line + [
                    'order_id' => $order->id,
                ]);
            }

            return $order;
        });

        return $order;
    }
}
