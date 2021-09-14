<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaravanController;
use App\Http\Controllers\CaravanDatesController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CarLicensePlateController;
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
    Route::resource('caravans', CaravanController::class);
    Route::resource('caravanDates', CaravanDatesController::class);

    Route::post('caravanDates/sendExcel/{from?}/{until?}', [CaravanDatesController::class, 'sendExcel'])->name('caravanDates.sendExcel');
    Route::post('caravan/price/calculate', [PriceController::class, 'calculate'])->name('caravan.price.calculate');
    Route::get('caravan/price/excel/{from?}', [PriceController::class, 'excel'])->name('caravan.price.excel');
    Route::get('caravan/price/pdf/{from?}', [PriceController::class, 'pdf'])->name('caravan.price.pdf');

    Route::get('car/info/{caravan}', [CarLicensePlateController::class, 'info'])->name('car.info');
});
