<?php

namespace App\Http\Middleware;

class AllowIfAdmin
{
    /**
     * Grant access if user is an Admin.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure  $next
     * @param  null  $guard
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        $user = $request->user();

        if ( ! $user || ! $user->hasRole('Admin')) abort(401);

        return $next($request);
    }
}