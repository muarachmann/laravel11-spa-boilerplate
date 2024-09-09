<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ADMIN routes for your application. These
| routes are loaded by the RouteServiceProvider.
| Enjoy building your ADMIN DASHBOARD!
|
*/

// ======================================
// ADMIN AUTHENTICATED ROUTES
// ======================================

Route::group([
    'prefix' => 'admin/dashboard',
    'as' => 'admin.',
    'middleware' => ['auth', 'role:owner|admin']
], function () {

    Route::get('', [AdminController::class, 'dashboard'])->name('dashboard');

    //  ======== USERS ROUTE ===========
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'store' => 'users.store',
        'destroy' => 'users.destroy'
    ]);
    Route::get('users/data/load', [UserController::class, 'loadData'])->name('users.data');

    // Enter admin routes here ...


});
