<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Authorized providers.
     *
     * @var array
     */
    protected $providers = [
        'google',
        'facebook',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect to specified authentication provider.
     *
     * @param string $provider
     */
    public function redirectToProvider(string $provider)
    {
        if ( ! in_array($provider, $this->providers)) {
            return abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the authentication provider callback.
     *
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback(string $provider)
    {
        $user = Socialite::driver($provider)->user();

        /** @var \App\User $user */
        $user = User::updateOrCreate([
            'email' => $user->getEmail()
        ], [
            $provider . '_id' => $user->getId(),
            'name' => $user->getName(),
        ]);

        Auth::login($user);

        return redirect($this->redirectPath());
    }
}
