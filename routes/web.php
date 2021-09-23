<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CaravanAdminController;
use App\Http\Controllers\CaravanDatesController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CarLicensePlateController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCaravanController;
use App\Http\Controllers\Admin\AdminCaravanDatesController;
use App\Http\Controllers\Admin\AdminPriceController;
use App\Http\Controllers\Admin\AdminCarLicensePlateController;
use App\Http\Controllers\Admin\AdminMapController;
use App\Http\Controllers\Admin\AdminRouteController;
use App\Http\Controllers\Admin\AdminDashboardController;

Auth::routes();
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('', [Controller::class, 'main'])->name('main');

Route::group([
    'prefix'    => 'admin',
    'as'        => 'admin.',
    'middleware' => ['auth'],
],function () {
    Route::get('', [AdminController::class, 'main'])->name('main');
    Route::get('dashboard', [AdminDashboardController::class, 'show'])->name('dashboard');
    Route::resource('caravans', AdminCaravanController::class);
    Route::resource('caravanDates', AdminCaravanDatesController::class);

    Route::post('caravanDates/sendExcel/{from?}', [AdminCaravanDatesController::class, 'sendExcel'])->name('caravanDates.sendExcel');
    Route::post('caravan/price/calculate', [AdminPriceController::class, 'calculate'])->name('caravan.price.calculate');
    Route::get('caravan/price/excel/{from?}', [AdminPriceController::class, 'excel'])->name('caravan.price.excel');
    Route::get('caravan/price/pdf/{from?}', [AdminPriceController::class, 'pdf'])->name('caravan.price.pdf');

    Route::get('car/info/{caravanId}', [AdminCarLicensePlateController::class, 'info'])->name('car.info');
    Route::get('map/nautic', [AdminMapController::class, 'nautic'])->name('map.nautic');
    Route::get('route/current', [AdminRouteController::class, 'setCurrentMenu'])->name('route.current');
});

Route::group([
    'as'  => 'public.',
],function () {
    Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::resource('caravans', CaravanController::class);
    Route::resource('caravanDates', CaravanDatesController::class);

    Route::get('map/nautic', [MapController::class, 'nautic'])->name('map.nautic');
    Route::get('route/current', [RouteController::class, 'setCurrentMenu'])->name('route.current');
});
