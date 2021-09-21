<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaravanController;
use App\Http\Controllers\CaravanDatesController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CarLicensePlateController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RouteController;

Auth::routes();
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::group([
    'middleware' => ['auth'],
],function () {
    Route::resource('caravans', CaravanController::class);
    Route::resource('caravanDates', CaravanDatesController::class);

    Route::post('caravanDates/sendExcel/{from?}', [CaravanDatesController::class, 'sendExcel'])->name('caravanDates.sendExcel');
    Route::post('caravan/price/calculate', [PriceController::class, 'calculate'])->name('caravan.price.calculate');
    Route::get('caravan/price/excel/{from?}', [PriceController::class, 'excel'])->name('caravan.price.excel');
    Route::get('caravan/price/pdf/{from?}', [PriceController::class, 'pdf'])->name('caravan.price.pdf');

    Route::get('car/info/{caravan}', [CarLicensePlateController::class, 'info'])->name('car.info');
    Route::get('map/nautic', [MapController::class, 'nautic'])->name('map.nautic');
    Route::get('route/current', [RouteController::class, 'setCurrentMenu'])->name('route.current');
});
