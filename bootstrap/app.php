<?php

use App\Exceptions\GeneralException;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\Localization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // API routes
            Route::middleware('api')
                ->prefix('api')
                ->name('api.')
                ->group(base_path('routes/api.php'));

            Route::middleware(['web'])->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->redirectGuestsTo('/login');

//        $middleware->validateCsrfTokens(
//            except: ['todo/*'] // todo add exceptions here
//        );

        $middleware->web(append: [
            StartSession::class,
            Localization::class,
            HandleInertiaRequests::class,
        ]);

        $middleware->api(append: [
            Localization::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (GeneralException $e) {
            // ...
        });
    })->create();

