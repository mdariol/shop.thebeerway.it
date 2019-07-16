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
    protected $redirectTo = '/email/verify';

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

        if ( ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice', [
                'user' => $user->id,
            ]);
        }

        Auth::login($user);

        return redirect($this->redirectPath());
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $username = $this->username();

        /** @var \App\User $user */
        $user = User::where($username, $request->$username)->first();

        // If the user has not verified email we will disallow login and
        // redirect to verification.notice route.
        if ($user && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice', [
              'user' => $user->id,
            ]);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
