<?php

use App\User;

if (! function_exists('cart')) {
    /**
     * Get logged-in user's cart, or given user's cart.
     *
     * @param  \App\User|int|null  $user
     * @return \App\Order|null
     */
    function cart($user = null) {
        if (is_null($user)) {
            $user = auth()->user();
        }

        if (is_numeric($user)) {
            $user = User::find($user)->cart();
        }

        if (is_a($user, User::class)) {
            return $user->cart();
        }

        return null;
    }
}
