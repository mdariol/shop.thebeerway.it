<?php

namespace App;

use App\Mail\UserVerifyEmail;
use App\Traits\HasFilters;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Session;
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
        'password', 'is_horeca', 'profile_image',
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
     * Get related companies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_has_users');
    }

    /**
     * Get related default company.
     *
     * @return \App\Company|null
     */
    public function getDefaultCompanyAttribute()
    {
        $id = DB::table('user_default_company')
            ->where('user_id', $this->id)->value('company_id');

        return Company::find($id);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        Mail::to($this)->send(new UserVerifyEmail($this));
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
     * Whether user owns specified company or not.
     *
     * @return bool
     */
    public function owns(Company $company)
    {
        return $this->is($company->owner);
    }

    public function getDraftOrder(){


        $order = $this->orders()->where('state','draft')->first();

        if ($order) {
            $oldCart = new Cart(null);
            $oldCart->order_id = $order->id;
            $oldCart->totalPrice = $order->total_amount;
            $oldCart->deliverynote = $order->deliverynote;
            $oldCart->company_id = $order->company_id;
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



}
