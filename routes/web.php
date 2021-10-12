<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\CustomerLoginController;

use App\Http\Controllers\Admin\AdminCaravanController;
use App\Http\Controllers\Admin\AdminCaravanDatesController;
use App\Http\Controllers\Admin\AdminPriceController;
use App\Http\Controllers\Admin\AdminCarLicensePlateController;
use App\Http\Controllers\Admin\AdminRouteController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminPermissionController;
Use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Admin\AdminBoatController;
use App\Http\Controllers\Admin\AdminWidgetController;
use App\Http\Controllers\Admin\AdminUploadController;
use App\Http\Controllers\Admin\AdminBoatDatesController;
use App\Http\Controllers\Admin\AdminBoatGuestDatesController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminResetPasswordController;

//Auth::routes();

Route::get('', function () {
    return redirect('dashboard');
});

Route::group([
    'as'  => 'customer.',
],function () {
    Route::get('login', [CustomerLoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('login', [CustomerLoginController::class, 'login'])->name('login.check');
    Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');
});

Route::group([
    'as'  => 'public.',
],function () {
    Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::resource('pages', PageController::class);
    Route::resource('widgets', WidgetController::class);
    Route::get('route/current/{currentRouteName}', [RouteController::class, 'setCurrentMenu'])->name('route.current');
});

Route::group([
    'prefix'    => 'admin',
    'as'        => 'admin.',
],function () {
    Route::get('login', [AdminLoginController::class,'showLoginForm'])->name('login.form');
    Route::post('login', [AdminLoginController::class,'login'])->name('login');
    Route::get('password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AdminResetPasswordController::class, 'reset'])->name('password.update');
});

Route::group([
    'prefix'    => 'admin',
    'as'        => 'admin.',
    'middleware' => ['auth:admin'],
],function () {
    Route::get('', [AdminDashboardController::class, 'show'])->name('dashboard');
    Route::post('logout', [AdminLoginController::class,'logout'])->name('logout');

    Route::get('customers/guests', [AdminCustomerController::class,'guests'])->name('customers.guests');
    Route::get('boats/guests', [AdminBoatController::class,'guests'])->name('boats.guests');
    Route::get('boatDates/saison', [AdminBoatDatesController::class, 'saison'])->name('boatDates.saison');
    Route::get('boatDates/winter', [AdminBoatDatesController::class, 'winter'])->name('boatDates.winter');

    Route::resource('customers', AdminCustomerController::class);
    Route::resource('caravans', AdminCaravanController::class);
    Route::resource('caravanDates', AdminCaravanDatesController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('roles', AdminRoleController::class);
    Route::resource('permissions', AdminPermissionController::class);
    Route::resource('pages', AdminPageController::class);
    Route::resource('widgets', AdminWidgetController::class);
    Route::resource('boats', AdminBoatController::class);
    Route::resource('boatDates', AdminBoatDatesController::class);


    Route::post('caravanDates/sendExcel', [AdminCaravanDatesController::class, 'sendExcel'])->name('caravanDates.sendExcel');
    Route::match(['post','put'],'caravan/price/calculate', [AdminPriceController::class, 'calculate'])->name('caravan.price.calculate');
    Route::get('caravan/price/excel/{year?}/{month?}', [AdminPriceController::class, 'excel'])->name('caravan.price.excel');
    Route::get('caravan/price/pdf/{year?}/{month?}', [AdminPriceController::class, 'pdf'])->name('caravan.price.pdf');
    Route::get('car/info/{caravanId}', [AdminCarLicensePlateController::class, 'info'])->name('car.info');
    Route::get('route/current/{currentRouteName}', [AdminRouteController::class, 'setCurrentMenu'])->name('route.current');
    Route::get('routes', [AdminRouteController::class, 'routes'])->name('routes.index');
    Route::post('upload/image/{paramName}', [AdminUploadController::class, 'imageUpload'])->name('upload.image');
});
Route::fallback(function () {
    return redirect('');
});
