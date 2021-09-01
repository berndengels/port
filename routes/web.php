<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CaravanController;
use App\Http\Controllers\CaravanDatesController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\CarLicensePlateController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
*/
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
*/

Route::group([
    'middleware' => ['auth', 'verified'],
],function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('caravans', CaravanController::class);
    Route::resource('caravanDates', CaravanDatesController::class);

    Route::post('caravan/price/calculate', [PriceController::class, 'calculate'])->name('caravan.price.calculate');
    Route::get('caravan/price/excel/{from?}', [PriceController::class, 'excel'])->name('caravan.price.excel');
    Route::get('caravan/price/pdf/{from?}', [PriceController::class, 'pdf'])->name('caravan.price.pdf');

    Route::get('car/info/{caravan}', [CarLicensePlateController::class, 'info'])->name('car.info');
});
