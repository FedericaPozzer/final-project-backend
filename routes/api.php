<?php

use App\Http\Controllers\api\OrderApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\RestaurantApiController;
use App\Http\Controllers\api\TypeApiController;

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

Route::resource('restaurants', RestaurantApiController::class);
Route::resource('orders', OrderApiController::class);
Route::resource('types', TypeApiController::class);

