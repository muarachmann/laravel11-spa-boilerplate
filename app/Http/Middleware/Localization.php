<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ContainerExceptionInterface
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // check if user is authenticated and return their locale
        $user = request()->user();
        if ($user) {
            // todo get users locale [from database or use logic here]
            // $locale = $user->locale;
            // if ($locale) {
            //    App::setLocale($locale);
            //    Carbon::setlocale($locale);
            //    return $next($request);
            // }
        }

        // Check header request and determine localization
        if ($request->ajax() || $request->wantsJson()) {
            // Get locale from request headers
            $locale = $request->getPreferredLanguage();
            // Get root locale, i.e. string before the first underscore
            $locale = Str::before($locale, '_'); // en
            // Now set app locale for current request
            App::setLocale($locale);
            Carbon::setlocale($locale);
        } else {
            // check if the request has language header
            if (session()->has('locale')) {
                App::setlocale(session()->get('locale'));
                Carbon::setlocale(session()->get('locale'));
            } else {
                App::setlocale('en');
                Carbon::setlocale('en');
            }
        }

        return $next($request);
    }
}
