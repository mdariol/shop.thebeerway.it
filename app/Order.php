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

    protected $with = ['lines'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrdersScope);
    }

    /**
     * Get related user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get related lines.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines()
    {
        return $this->hasMany(Line::class);
    }

    /**
     * Get related billing profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function billing_profile()
    {
        return $this->belongsTo(BillingProfile::class);
    }

    /**
     * Get related shipping address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipping_address()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    /**
     * Get related policy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    /**
     * Increase the line's quantity. If there's no line, add a line.
     *
     * @param  Beer  $beer
     * @param  int  $quantity
     * @return bool|int
     */
    public function add(Beer $beer, int $quantity = 1)
    {
        $line = $this->lines()->where('beer_id', $beer->id)->first();

        if ( ! $line) {
            return Line::create([
                'order_id' => $this->id,
                'beer_id' => $beer->id,
                'unit_price' => $beer->price->distribution,
                'price' => $beer->price->distribution * $quantity,
                'qty' => $quantity,
            ]);
        }

        $line->qty += $quantity;

        return $line->update([
            'price' => $line->unit_price * $line->qty,
        ]);
    }

    /**
     * Decrease the line's quantity. If no quantity is specified, removes the line.
     *
     * @param  Beer  $beer
     * @param  int|null  $quantity
     * @return bool|int|mixed|null
     * @throws \Exception
     */
    public function remove(Beer $beer, int $quantity = null)
    {
        $line = $this->lines()->where('beer_id', $beer->id)->first();
        $line->qty -= $quantity;

        if ( ! $quantity || $line->qty < 1) {
            return $line->delete();
        }

        return $line->update([
            'price' => $line->unit_price * $line->qty,
        ]);
    }

    /**
     * Remove all lines.
     */
    public function empty()
    {
        $this->lines()->each(function ($line) {
            $line->delete();
        });
    }

    /**
     * Whether the order is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->lines()->doesntExist();
    }

    /**
     * Whether the order has given beer or not.
     *
     * @param  Beer  $beer
     * @return bool
     */
    public function has(Beer $beer)
    {
        return $this->lines()->where('beer_id', $beer->id)->exists();
    }

    /**
     * Count the number of order's items.
     *
     * @return int
     */
    public function countItems()
    {
        return $this->lines->reduce(function ($carry, $line) {
            return $carry + $line->qty;
        }, 0);
    }

    /**
     * Whether all beers are in stock or not.
     *
     * @return bool
     */
    public function checkStock()
    {
        return $this->lines->every(function ($line) {
            /** @var \App\Line $line */
            return $line->checkStock();
        });
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
