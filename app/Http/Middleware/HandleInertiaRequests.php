<?php

namespace App\Http\Middleware;

use App\Support\Utils\Initials;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Middleware;
use Jenssegers\Agent\Facades\Agent;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param Request $request
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function share(Request $request): array
    {
        if (App::isDownForMaintenance()) {
            Debugbar::disable();
            $this->rootView = 'maintenance';
        }

        $shared = $this->getShared($request);
        return array_merge(parent::share($request), $shared);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param Request $request
     * @return array
     */
    public function getShared(Request $request): array
    {
        $authUser = $this->getAuthenticatedUser($request);
        return [
            'logo' => asset('images/logo.png'),
            'app_name' => config('app.name'),
            'app_version' => config('app.version'),
            'auth' => ['user' => $authUser['user']],
            'user_roles' => $authUser['roles'],
            'device_type' => Agent::isTablet() ? 1 : (Agent::isMobile() ? 3 : 0),
            'user_permissions' => $authUser['permissions'],
            'flash' => function () use ($request) {
                return [
                    'error' => $request->session()->get('error'),
                    'success' => $request->session()->get('success'),
                    'info' => $request->session()->get('info'),
                    'warning' => $request->session()->get('warning'),
                    'message' => $request->session()->get('message')
                ];
            },
            'notifications_count' => $authUser['notifications_count']
        ];
    }

    /**
     * Get currently authenticated user, user_roles and currency
     * @param Request $request
     * @return array
     */
    protected function getAuthenticatedUser(Request $request): array
    {
        $user = $request->user();
        $user_details['user'] = $user ? [
            'id' => $user->id,
            'phone' => $user->phone,
            'user_code' => $user->user_code,
            'email' => $user->email,
            'name' => $user->name,
            'initials' => Initials::generate($user->name),
            'username' => $user->username,
            'image' => $user->profile_picture,
            'is_active' => $user->is_active,
            'is_verified' => $user->is_verified,
            'timezone' => $user->timezone
        ] : null;
        $user_details['roles'] = $user ?
            ($user->roles ? $user->roles->pluck('name') : []) : [];
        $user_details['permissions'] = $user ?
            ($user->permissions ? $user->permissions->pluck('name') : []) : [];
        $user_details['notifications_count'] = $user ? $user->unreadNotifications->count() : null;

        return $user_details;
    }
}
