<?php

namespace App;

use App\Traits\HasState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasState;

    const WORKFLOW = 'approval';

    protected $fillable = [
        'business_name',
        'vat_number',
        'route',
        'postal_code',
        'city',
        'district',
        'country',
        'pec',
        'sdi',
        'owner_id',
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
     * Set this company as default for logged-in user.
     *
     * @return $this
     */
    public function default()
    {
        DB::table('user_default_company')->updateOrInsert(
            ['user_id' => auth()->id()],
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
            ['user_id', '=', auth()->id()],
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

    /**
     * Whether is pending or not.
     *
     * @return bool
     */
    public function getIsPendingAttribute()
    {
        return $this->state === 'approval';
    }

    /**
     * Whether is approved or not.
     *
     * @return bool
     */
    public function getIsApprovedAttribute()
    {
        return $this->state === 'approved';
    }

    /**
     * Whether is rejected or not.
     *
     * @return bool
     */
    public function getIsRejectedAttribute()
    {
        return $this->state === 'rejected';
    }

    /**
     * Get the owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
