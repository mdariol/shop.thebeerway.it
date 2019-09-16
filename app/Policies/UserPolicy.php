<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the index.
     *
     * @param \App\User  $user
     *
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     *
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     *
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can assign roles.
     *
     * @param  \App\User  $user
     *
     * @return bool
     */
    public function role(User $user)
    {
        return $user->hasRole('Admin');
    }
}
