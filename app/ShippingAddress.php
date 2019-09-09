<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShippingAddress extends Model
{
    protected $fillable = [
        'name', 'route', 'postal_code', 'city',
        'district', 'country', 'phone', 'company_id',
    ];

    /**
     * Get related company.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
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
        DB::table('company_default_shipping_address')->updateOrInsert(
            ['company_id' => $this->company->id],
            ['shipping_address_id' => $this->id]
        );

        return $this;
    }

    /**
     * Whether is default shipping address for related company or not.
     *
     * @return bool
     */
    public function getIsDefaultAttribute()
    {
        return DB::table('company_default_shipping_address')->where([
            ['company_id', '=', $this->company->id],
            ['shipping_address_id', '=', $this->id],
        ])->exists();
    }
}
