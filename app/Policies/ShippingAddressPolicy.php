<?php

namespace App\Policies;

use App\User;
use App\ShippingAddress;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingAddressPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the shipping address.
     *
     * @param  \App\User  $user
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return mixed
     */
    public function update(User $user, ShippingAddress $shippingAddress)
    {
        return $user->companies->contains($shippingAddress->company);
    }

    /**
     * Determine whether the user can delete the shipping address.
     *
     * @param  \App\User  $user
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return mixed
     */
    public function delete(User $user, ShippingAddress $shippingAddress)
    {
        return $user->companies->contains($shippingAddress->company);
    }

    /**
     * Determine whether the user can set the shipping address as default.
     *
     * @param  \App\User  $user
     * @param  \App\ShippingAddress  $shippingAddress
     *
     * @return mixed
     */
    public function default(User $user, ShippingAddress $shippingAddress)
    {
        return $user->companies->contains($shippingAddress->company);
    }
}
