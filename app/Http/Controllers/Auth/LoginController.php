<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LoginController extends Controller implements HasMiddleware
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
    protected string $redirectTo = '/';


    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['logout']),
            new Middleware('auth', only: ['logout']),
        ];
    }

    /**
     * Get the login username to be used by the controller (email|username).
     *
     * @return string
     */
    public function username(): string
    {
        return 'username';
    }

    /**
     * Shows the login form
     * @return Response
     */
    public function showLoginForm(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Attempt login controller for user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function login(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $credentials = $request->validate([
            'email' => 'nullable|required_without:phone|email',
            'phone' => 'nullable|required_without:email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = request()->user();
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);
            return Inertia::location($this->redirectTo());
        }

        return Redirect::back()->with('error', __('auth.failed'));
    }

    /**
     * Login using socialite driver
     * @param string $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
     */
    public function providerLogin(string $provider): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Socialite callback handler
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handleProviderCallback(string $provider): \Symfony\Component\HttpFoundation\Response
    {
        try {
            $providerUser = Socialite::driver($provider)->user();

            // First Find Social Account
            $socialAccount = SocialAccount::where([
                'provider_name' => $provider,
                'provider_id' => $providerUser->getId()
            ])->first();

            // If Social Account Exist then Find User and Login
            if ($socialAccount) {
                Auth::guard('users')->login($socialAccount->user);
                return Inertia::location($this->redirectTo());
            }

            // Find User
            $user = User::where(['email' => $providerUser->getEmail()])->first();

            // If User not get then create new user
            if (!$user) {
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'username' => generateUsername($providerUser->getName()),
                    'user_code' => generateUserCode(),
                    'password' => bcrypt($providerUser->getId().Str::random(8)),
                    'email_verified_at' => now(),
                ]);
                $user->syncRoles(['user']);
            }

            // Create Social Accounts
            $user->socialAccounts()->create([
                'provider_id'=> $providerUser->getId(),
                'provider_name' => $provider
            ]);
            Auth::guard('users')->login($user);
            return Inertia::location($this->redirectTo());
        } catch(\Exception $e) {
            return redirect()->route('guest.login')->with('error', $e->getMessage());
        }
    }

    /**
     * Redirect function
     * @return string
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function redirectTo(): string
    {
        if ($intendedUrl = session()->get('url.intended')) {
            return $intendedUrl;
        }

        return route('guest.index');
    }
}
