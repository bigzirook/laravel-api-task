<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,AirDuctCleaningController};

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('register','register');
    Route::post('login', 'login');

});

Route::middleware('auth:api')->group(function () {
    Route::controller(AuthController::class)->group(function(){
        Route::post('logout', 'logout');
    });

    Route::resource('air-ducts', 'App\Http\Controllers\AirDuctCleaningController');
    Route::resource('dryer-vents', 'App\Http\Controllers\DryerVentCleaningController');

});

