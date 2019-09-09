<?php

namespace App\Policies;

use App\User;
use App\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     *
     * @return mixed
     */
    public function view(User $user, Company $company)
    {
        return $company->users->contains($user);
    }

    /**
     * Determine whether the user can update the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     *
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        return $company->users->contains($user);
    }

    /**
     * Determine whether the user can delete the company.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     *
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        return $company->users->contains($user);
    }

    /**
     * Determine whether the user can set the company as default.
     *
     * @param  \App\User  $user
     * @param  \App\Company  $company
     *
     * @return mixed
     */
    public function default(User $user, Company $company)
    {
        return $company->users->contains($user);
    }
}
