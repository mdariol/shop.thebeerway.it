<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'vat_number', 'pec', 'sdi',
        'business_name', 'address',
    ];

    /**
     * Get related users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'company_has_users');
    }

    /**
     * Get related shipping addresses.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
