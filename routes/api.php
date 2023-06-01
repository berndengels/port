<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminPriceController;
use App\Http\Controllers\Api\ApiWeatherController;
use App\Http\Controllers\Api\ApiStatisticController;
use App\Http\Controllers\Api\ApiCaravanController;
use App\Http\Controllers\Api\ApiRentalsController;
use App\Http\Controllers\Api\ApiConfigOfferController;
use App\Http\Controllers\Api\ApiBerthController;
use App\Http\Controllers\Api\ApiCraneDateController;

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

Route::get('weather',ApiWeatherController::class)->name('weather');
Route::group([
    'prefix'    => 'stats',
    'as'        => 'stats.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('caravans',[ApiStatisticController::class,'caravans'])->name('caravans');
    Route::get('boats',[ApiStatisticController::class,'boats'])->name('boats');
    Route::get('guestBoats',[ApiStatisticController::class,'guestBoats'])->name('guestBoats');
    Route::get('rentals',[ApiStatisticController::class,'rentals'])->name('rentals');
    Route::get('rentalSalesVolumes',[ApiStatisticController::class,'rentalSalesVolumes'])->name('rentalSalesVolumes');
});
Route::group([
    'prefix'    => 'caravans',
    'as'        => 'caravans.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('todayVisits',[ApiCaravanController::class,'todayVisits'])->name('todayVisits');
    Route::put('{caravan}',[ApiCaravanController::class,'update'])->name('update');
    Route::post('',[ApiCaravanController::class,'store'])->name('store');
});
Route::group([
    'prefix'    => 'rentals',
    'as'        => 'rentals.',
//    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('',[ApiRentalsController::class,'index'])->name('index');
    Route::get('reservations',[ApiRentalsController::class,'reservations'])->name('reservations');
});
Route::group([
    'prefix'    => 'configOffers',
    'as'        => 'configOffers.',
//    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('',[ApiConfigOfferController::class,'index'])->name('index');
});
Route::group([
    'prefix'    => 'berths',
    'as'        => 'berths.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::post('refill', [ApiBerthController::class,'refill'])->name('refill');
    Route::post('setPoints', [ApiBerthController::class,'setPoints'])->name('setPoints');
    Route::get('', [ApiBerthController::class,'index'])->name('index');
    Route::get('laodBackup', [ApiBerthController::class,'loadBackup'])->name('loadBackup');
    Route::get('saveBackup', [ApiBerthController::class,'saveBackup'])->name('saveBackup');
    Route::get('port', [ApiBerthController::class,'port'])->name('port');
    Route::get('categories', [ApiBerthController::class,'categories'])->name('categories');
    Route::get('docks', [ApiBerthController::class,'docks'])->name('docks');
    Route::get('', [ApiBerthController::class,'index'])->name('index');
    Route::post('', [ApiBerthController::class,'store'])->name('store');
    Route::put('{berth}', [ApiBerthController::class,'update'])->name('update');
    Route::delete('{berth}', [ApiBerthController::class,'destroy'])->name('destroy');
    Route::delete('', [ApiBerthController::class,'destroyAll'])->name('destroyAll');
    Route::post('batchDestroy', [ApiBerthController::class,'destroyAny'])->name('destroyAny');
});

Route::group([
//    'prefix'    => 'craneDates',
    'as'        => 'craneDates.',
    'middleware' => ['auth:sanctum'],
], function () {
    Route::resource('craneDates', ApiCraneDateController::class);
    Route::post('craneDates/cranable', [ApiCraneDateController::class, 'cranable']);
/*
    Route::post('refill', [ApiBerthController::class,'refill'])->name('refill');
    Route::post('setPoints', [ApiBerthController::class,'setPoints'])->name('setPoints');
    Route::get('', [ApiBerthController::class,'index'])->name('index');
    Route::get('laodBackup', [ApiBerthController::class,'loadBackup'])->name('loadBackup');
    Route::get('saveBackup', [ApiBerthController::class,'saveBackup'])->name('saveBackup');
    Route::get('port', [ApiBerthController::class,'port'])->name('port');
    Route::get('categories', [ApiBerthController::class,'categories'])->name('categories');
    Route::get('docks', [ApiBerthController::class,'docks'])->name('docks');
    Route::get('', [ApiBerthController::class,'index'])->name('index');
    Route::post('', [ApiBerthController::class,'store'])->name('store');
    Route::put('{berth}', [ApiBerthController::class,'update'])->name('update');
    Route::delete('{berth}', [ApiBerthController::class,'destroy'])->name('destroy');
    Route::delete('', [ApiBerthController::class,'destroyAll'])->name('destroyAll');
    Route::post('batchDestroy', [ApiBerthController::class,'destroyAny'])->name('destroyAny');
*/
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
