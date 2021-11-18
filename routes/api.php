<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Api\CaravanController;
use App\Http\Controllers\Admin\AdminPriceController;

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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::group([
    'prefix'    => 'admin',
    'as'        => 'admin.',
    'middleware' => ['auth:admin'],
],function () {
    //Route::post('caravan/price/calculate', [AdminPriceController::class, 'calculate'])->name('caravan.price.calculate');
});
Route::get('weather',WeatherController::class)->name('weather');
Route::get('caravan/stats',[CaravanController::class,'stats'])->name('caravan.stats');
