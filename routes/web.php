<?php

use App\Http\Controllers\LocaleController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Main Routes
|--------------------------------------------------------------------------
| Register all routes that leads to main platform and external portals if necessary.
*/

Route::group([
    'as' => 'guest.',
], function () {

    // Static Pages
    Route::get('', [PagesController::class, 'index'])->name('index');
    Route::get('about', [PagesController::class, 'about'])->name('about');
    Route::get('licensing', [PagesController::class, 'about'])->name('licensing');

    // Authentication routes (login, registration, etc)
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.request.send');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])
        ->name('password.update');

    // Route to handle the Facebook & Google login
    Route::get('login/{service}', [LoginController::class, 'providerLogin'])->name('social.auth');
    Route::get('login/{service}/callback', [LoginController::class, 'handleProviderCallback'])
        ->name('social.auth.callback');
});


/*=======================
    Language Route
=======================*/
Route::get('lang/{lang}', [LocaleController::class, 'setLocale'])->name('locale.set');

// Fallback route
Route::fallback(function () {
    return Inertia::render('Errors/Index', ['status' => 404]);
});
