<?php

namespace App\Policies;

use App\User;
use App\BillingProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillingProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the billing-profile.
     *
     * @param  \App\User  $user
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return mixed
     */
    public function view(User $user, BillingProfile $billingProfile)
    {
        return $billingProfile->users->contains($user);
    }

    /**
     * Determine whether the user can update the billing-profile.
     *
     * @param  \App\User  $user
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return mixed
     */
    public function update(User $user, BillingProfile $billingProfile)
    {
        return $billingProfile->users->contains($user);
    }

    /**
     * Determine whether the user can delete the billing-profile.
     *
     * @param  \App\User  $user
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return mixed
     */
    public function delete(User $user, BillingProfile $billingProfile)
    {
        return $billingProfile->users->contains($user);
    }

    /**
     * Determine whether the user can set the billing-profile as default.
     *
     * @param  \App\User  $user
     * @param  \App\BillingProfile  $billingProfile
     *
     * @return mixed
     */
    public function default(User $user, BillingProfile $billingProfile)
    {
        return $billingProfile->users->contains($user);
    }

    /**
     * Determine whether the user can apply transition.
     *
     * @param  \App\User  $user
     *
     * @return bool
     */
    public function transition(User $user)
    {
        return $user->hasRole('Admin');
    }
}
