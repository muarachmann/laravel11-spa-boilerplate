<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

if (!function_exists('page_direction')) {
    /**
     * Gets application page direction either rtl or ltr
     * Default is ltr.
     *
     * @return string
     */
    function page_direction(): string
    {
        $rtl_locales = config('app.rtl_locales', ['ae']);
        return in_array(app()->getLocale(), $rtl_locales) ? "rtl" : "ltr";
    }
}

if (!function_exists('redirectWithoutInertia')) {
    /**
     * Redirects without inertia
     * @param string $url
     * @return string
     */
    function redirectWithoutInertia(string $url): string
    {
        return response('', Response::HTTP_CONFLICT)
            ->header('x-inertia-location', $url);
    }
}

if (!function_exists('checkUserExists')) {
    /**
     * @param $user_param
     * @return boolean
     */
    function checkUserExists($user_param): bool
    {
        return User::where('username', '=', $user_param)
            ->orWhere('phone', '=', $user_param)
            ->orWhere('email', '=', $user_param)
            ->exists();
    }
}

if (!function_exists('generateUsername')) {
    /**
     * @param string $username
     * @return string
     */
    function generateUsername(string $username): string
    {
        $username = Str::replace(' ', '', $username);
        // todo check profane words
        if (checkUserExists($username) || in_array($username, config('app-settings.reserve_words'))) {
            $chars = '0123456789';
            $user_id = substr(str_shuffle($chars), 0, 4);
            $username = $username . $user_id;
            return generateUsername($username);
        } else {
            return $username;
        }
    }
}

if (!function_exists('generateUserCode')) {
    /**
     * Generate user code.
     * @param string $type
     * @return string
     */
    function generateUserCode(string $type = 'user'): string
    {
        return match($type){
            'owner' => Str::upper(str(uniqid("AO"))),
            'admin' => Str::upper(str(uniqid("AA"))),
            default => Str::upper(str(uniqid("AU"))),
        };
    }
}

if (!function_exists('supportedLocales')) {
    /**
     * Returns all supported locales of the application
     * @return Collection
     */
    function supportedLocales(): Collection
    {
        return collect(array_keys(config('app.supported_locales')))
            ->transform(function ($key) {
                return [
                    'name' => __('general.' . $key),
                    'code' => $key,
                    'flag' => asset('flags/' . $key . '.svg')
                ];
            });
    }
}

if (!function_exists('isInertiaRequest')) {
    /**
     * Check if the current request is an inertia request
     * @return bool
     */
    function isInertiaRequest(): bool
    {
        return request()->header('X-Inertia', false);
    }
}
