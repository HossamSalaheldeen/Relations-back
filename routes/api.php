<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\API\AuthController;
use \App\Http\Controllers\API\UserController;
use \App\Http\Controllers\API\ProfileController;
use \App\Http\Controllers\API\UserProfileController;
use \App\Http\Controllers\API\FlightController;

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

Route::post('login',[AuthController::class,'login']);
Route::apiResource('users',UserController::class);
Route::apiResource('profile',ProfileController::class);
Route::apiResource('flights',FlightController::class);
Route::apiResource('users.profile',UserProfileController::class);
Route::put('users',[UserController::class,'update']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user',[AuthController::class,'user']);
    Route::post('logout',[AuthController::class,'logout']);

});
