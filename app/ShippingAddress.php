<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShippingAddress extends Model
{
    protected $fillable = [
        'name', 'route', 'postal_code', 'city',
        'district', 'country', 'phone', 'billing_profile_id',
    ];

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
     * Get formatted address.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        return join(', ', [
            $this->route, $this->city,
            $this->district, $this->country,
        ]);
    }

    /**
     * Set current shipping address as default.
     *
     * @return $this
     */
    public function default()
    {
        DB::table('billing_profile_default_shipping_address')->updateOrInsert(
            ['billing_profile_id' => $this->billing_profile->id],
            ['shipping_address_id' => $this->id]
        );

        return $this;
    }

    /**
     * Whether is default shipping address for related billing-profile or not.
     *
     * @return bool
     */
    public function getIsDefaultAttribute()
    {
        return DB::table('billing_profile_default_shipping_address')->where([
            ['billing_profile_id', '=', $this->billing_profile->id],
            ['shipping_address_id', '=', $this->id],
        ])->exists();
    }
}
