<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function shipping_addresses()
    {
        return $this->hasMany(ShippingAddress::class)
            ->orderBy('name');
    }

    /**
     * Get related default shipping address.
     *
     * @return \App\ShippingAddress|null
     */
    public function getDefaultShippingAddressAttribute()
    {
        $id = DB::table('company_default_shipping_address')
            ->where('company_id', $this->id)
            ->value('shipping_address_id');

        return ShippingAddress::find($id);
    }

    /**
     * Set this company as default for specified user. If none user is
     * specified, use the logged-in user.
     *
     * @return $this
     */
    public function default()
    {
        DB::table('user_default_company')->updateOrInsert(
            ['user_id' => auth()->user()->id],
            ['company_id' => $this->id]
        );

        return $this;
    }

    /**
     * Whether is default company or not for logged-in user.
     *
     * @return bool
     */
    public function getIsDefaultAttribute()
    {
        return DB::table('user_default_company')->where([
            ['user_id', '=', auth()->user()->id],
            ['company_id', '=', $this->id]
        ])->exists();
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
