<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCaravanAdminController;
use App\Http\Controllers\AdminCaravanDatesController;
use App\Http\Controllers\AdminPriceController;
use App\Http\Controllers\AdminCarLicensePlateController;
use App\Http\Controllers\AdminMapController;
use App\Http\Controllers\AdminRouteController;

/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
*/
Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group([
    'middleware' => ['auth', 'verified'],
],function () {
    Route::resource('caravans', AdminCaravanAdminController::class);
    Route::resource('caravanDates', AdminCaravanDatesController::class);

    Route::post('caravanDates/sendExcel/{from?}', [AdminCaravanDatesController::class, 'sendExcel'])->name('caravanDates.sendExcel');
    Route::post('caravan/price/calculate', [AdminPriceController::class, 'calculate'])->name('caravan.price.calculate');
    Route::get('caravan/price/excel/{from?}', [AdminPriceController::class, 'excel'])->name('caravan.price.excel');
    Route::get('caravan/price/pdf/{from?}', [AdminPriceController::class, 'pdf'])->name('caravan.price.pdf');

    Route::get('car/info/{caravan}', [AdminCarLicensePlateController::class, 'info'])->name('car.info');
    Route::get('map/nautic', [AdminMapController::class, 'nautic'])->name('map.nautic');
    Route::post('route/current', [AdminRouteController::class, 'setCurrentMenu'])->name('route.current');
});
