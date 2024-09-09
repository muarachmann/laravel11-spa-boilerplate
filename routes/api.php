<?php

use App\Http\Controllers\API\V1\LabTestController;
use App\Http\Controllers\API\V1\MiscellaneousController;
use App\Http\Controllers\API\V1\RevenueController;
use App\Http\Controllers\API\V1\SearchController;
use App\Http\Controllers\API\V1\WaspitoGlobal\LabPartnerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API ROUTES
Route::group([
    'prefix' => 'v1',
    'namespace' => '\\\\',
    'as' => 'api.',
    'middleware' => ['json.response']
], function () {

    // Enter api routes here ...

});


