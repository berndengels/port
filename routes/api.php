<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminPriceController;
use App\Http\Controllers\Api\WeatherController;
use App\Http\Controllers\Api\StatisticController;
use App\Http\Controllers\Api\CaravanController;
use App\Http\Controllers\Api\RentalsController;
use App\Http\Controllers\Api\ConfigOfferController;
use App\Http\Controllers\Api\BerthController;

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
    Route::get('rentals',[StatisticController::class,'rentals'])->name('rentals');
    Route::get('rentalSalesVolumes',[StatisticController::class,'rentalSalesVolumes'])->name('rentalSalesVolumes');
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
    'prefix'    => 'rentals',
    'as'        => 'rentals.',
//    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('',[RentalsController::class,'index'])->name('index');
    Route::get('reservations',[RentalsController::class,'reservations'])->name('reservations');
});
Route::group([
    'prefix'    => 'configOffers',
    'as'        => 'configOffers.',
//    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('',[ConfigOfferController::class,'index'])->name('index');
});
Route::group([
    'prefix'    => 'berths',
    'as'        => 'berths.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::post('refill', [BerthController::class,'refill'])->name('refill');
    Route::post('setPoints', [BerthController::class,'setPoints'])->name('setPoints');
    Route::get('', [BerthController::class,'index'])->name('index');
    Route::get('laodBackup', [BerthController::class,'loadBackup'])->name('loadBackup');
    Route::get('saveBackup', [BerthController::class,'saveBackup'])->name('saveBackup');
    Route::get('port', [BerthController::class,'port'])->name('port');
    Route::get('categories', [BerthController::class,'categories'])->name('categories');
    Route::get('docks', [BerthController::class,'docks'])->name('docks');
    Route::get('', [BerthController::class,'index'])->name('index');
    Route::post('', [BerthController::class,'store'])->name('store');
    Route::put('{berth}', [BerthController::class,'update'])->name('update');
    Route::delete('{berth}', [BerthController::class,'destroy'])->name('destroy');
    Route::delete('', [BerthController::class,'destroyAll'])->name('destroyAll');
    Route::post('batchDestroy', [BerthController::class,'destroyAny'])->name('destroyAny');
});

if(!app()->environment('production')) {
    Route::group([
        'prefix'    => 'price',
        'as'        => 'price.',
    ], function () {
        Route::match(['post','put'],'caravanDates', [AdminPriceController::class, 'calculateCaravanPrices'])->name('caravanDates');
        Route::match(['post','put'],'boatDates', [AdminPriceController::class, 'calculateBoatPrices'])->name('boatDates');
        Route::match(['post','put'],'guestBoatDates', [AdminPriceController::class, 'calculateGuestBoatPrices'])->name('guestBoatDates');
        Route::match(['post','put'],'rentalDates', [AdminPriceController::class, 'calculateRentalPrices'])->name('rentalDates');
    });
}
