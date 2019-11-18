<?php

namespace App;

use App\Traits\HasFilters;
use App\Traits\HasState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BillingProfile extends Model
{
    use HasState, HasFilters;

    const WORKFLOW = 'approval';

    protected $fillable = [
        'name', 'vat_number', 'route', 'postal_code', 'legal_person',
        'city', 'district', 'country', 'pec', 'sdi', 'owner_id',
    ];

    protected $appends = ['is_default', 'address'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => \App\Events\BillingProfileCreated::class,
    ];

    /**
     * Get related users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'billing_profile_has_users');
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
     *
     * @deprecated Use defaultShippingAddress() or shippingAddress().
     * @see BillingProfile::defaultShippingAddress()
     * @see BillingProfile::shippingAddress()
     */
    public function getDefaultShippingAddressAttribute()
    {
        $id = DB::table('billing_profile_default_shipping_address')
            ->where('billing_profile_id', $this->id)
            ->value('shipping_address_id');

        return ShippingAddress::find($id);
    }

    /**
     * Get default shipping-address or the first one.
     *
     * @return ShippingAddress|null
     */
    public function shippingAddress()
    {
        $default = $this->defaultShippingAddress();

        if ($default) return $default;

        return $this->shipping_addresses->first();
    }

    /**
     * Get the default shipping-address.
     *
     * @return ShippingAddress|null
     */
    public function defaultShippingAddress()
    {
        $id = DB::table('billing_profile_default_shipping_address')
            ->where('billing_profile_id', $this->id)
            ->value('shipping_address_id');

        return ShippingAddress::find($id);
    }

    /**
     * Set this billing-profile as default for logged-in user.
     *
     * @return $this
     */
    public function default()
    {
        DB::table('user_default_billing_profile')->updateOrInsert(
            ['user_id' => auth()->id()],
            ['billing_profile_id' => $this->id]
        );

        return $this;
    }

    /**
     * Whether is default billing-profile or not for logged-in user.
     *
     * @return bool
     */
    public function getIsDefaultAttribute()
    {
        return DB::table('user_default_billing_profile')->where([
            ['user_id', '=', auth()->id()],
            ['billing_profile_id', '=', $this->id]
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

    /**
     * Get related orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
