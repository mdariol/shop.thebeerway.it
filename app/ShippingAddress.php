<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
