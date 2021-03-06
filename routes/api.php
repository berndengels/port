<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\CaravanController;
use App\Http\Controllers\Api\HouseboatController;
use App\Http\Controllers\Api\ConfigOfferController;
use App\Http\Controllers\Api\GuestboatBerthController;

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

Route::get('weather',WeatherController::class)->name('weather');
Route::group([
    'prefix'    => 'stats',
    'as'        => 'stats.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('caravans',[StatisticController::class,'caravans'])->name('caravans');
    Route::get('boats',[StatisticController::class,'boats'])->name('boats');
    Route::get('guestBoats',[StatisticController::class,'guestBoats'])->name('guestBoats');
});
Route::group([
    'prefix'    => 'caravans',
    'as'        => 'caravans.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('todayVisits',[CaravanController::class,'todayVisits'])->name('todayVisits');
    Route::put('{caravan}',[CaravanController::class,'update'])->name('update');
    Route::post('',[CaravanController::class,'store'])->name('store');
});
Route::group([
    'prefix'    => 'houseboats',
    'as'        => 'houseboats.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('',[HouseboatController::class,'index'])->name('index');
});
Route::group([
    'prefix'    => 'configOffers',
    'as'        => 'configOffers.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('',[ConfigOfferController::class,'index'])->name('index');
});
Route::group([
    'prefix'    => 'guestboatBerths',
    'as'        => 'guestboatBerths.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::post('refill', [GuestboatBerthController::class,'refill'])->name('refill');
    Route::get('', [GuestboatBerthController::class,'index'])->name('index');
    Route::get('port', [GuestboatBerthController::class,'port'])->name('port');
    Route::get('categories', [GuestboatBerthController::class,'categories'])->name('categories');
    Route::get('docks', [GuestboatBerthController::class,'docks'])->name('docks');
    Route::get('', [GuestboatBerthController::class,'index'])->name('index');
    Route::post('', [GuestboatBerthController::class,'store'])->name('store');
    Route::put('{guestBoatBerth}', [GuestboatBerthController::class,'update'])->name('update');
    Route::delete('{guestBoatBerth}', [GuestboatBerthController::class,'destroy'])->name('destroy');
});
