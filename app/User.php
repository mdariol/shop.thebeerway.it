<?php

namespace App;

use App\Traits\HasFilters;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, HasFilters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'google_id', 'facebook_id', 'name', 'email',
        'password', 'profile_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get related billing profiles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function billing_profiles()
    {
        return $this->belongsToMany(BillingProfile::class, 'billing_profile_has_users');
    }

    /**
     * Get related default billing-profile.
     *
     * @return \App\BillingProfile|null
     */
    public function getDefaultBillingProfileAttribute()
    {
        $id = DB::table('user_default_billing_profile')
            ->where('user_id', $this->id)->value('billing_profile_id');

        return BillingProfile::find($id);
    }

    /**
     * Get related User Promotions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_users')->withTimestamps();
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

    /**
     * Whether user owns specified billing-profile or not.
     *
     * @param \App\BillingProfile $billingProfile
     *
     * @return bool
     */
    public function owns(BillingProfile $billingProfile)
    {
        return $this->is($billingProfile->owner);
    }

    /**
     * Whether user is horeca or not.
     *
     * @return bool
     */
    public function isHoreca()
    {
        return $this->billing_profiles()
            ->where('state', 'approved')
            ->where('legal_person', true)
            ->exists();
    }

    /**
     * @deprecated
     * @see \App\User::cart()
     */
    public function getDraftOrder(){
        $order = $this->orders()->where('state','draft')->first();

        if ($order) {
            $oldCart = new Cart(null);
            $oldCart->order_id = $order->id;
            $oldCart->totalPrice = $order->total_amount;
            $oldCart->deliverynote = $order->deliverynote;
            $oldCart->billing_profile_id = $order->billing_profile_id;
            $oldCart->shipping_address_id = $order->shipping_address_id;

            $storedItem = null;

            $oldCart->totalQty = 0;

            foreach ($order->lines as $line){
                $storedItem['item'] = Beer::find($line->beer_id);
                $storedItem['qty'] = $line->qty;
                $storedItem['unit_price'] = $line->unit_price;
                $storedItem['price'] = $line->price;
                $storedItem['beer'] = $storedItem['item']->name;
                $storedItem['brewery'] = $line->beer->getRelation('brewery')->getAttribute('name');
                $storedItem['packaging'] = $line->beer->getRelation('packaging')->getAttribute('name');
                $oldCart->items[$line->beer_id] = $storedItem;
                $oldCart->totalQty += $line->qty;
            }

            $cart = new Cart($oldCart);

            request()->session()->put('cart', $cart);
        }
    }

    /**
     * Get user's cart.
     *
     * @return Order
     */
    public function cart()
    {
        return Order::firstOrCreate([
            'user_id' => $this->id,
            'state' => 'draft',
        ]);
    }
}
