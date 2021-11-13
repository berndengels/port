<?php

use App\Http\Controllers\Admin\AdminInfoController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CaptchaServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\BoatDatesController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\ServiceRequestController;

use App\Http\Controllers\Admin\AdminCaravanController;
use App\Http\Controllers\Admin\AdminCaravanDatesController;
use App\Http\Controllers\Admin\AdminPriceController;
use App\Http\Controllers\Admin\AdminCarLicensePlateController;
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
use App\Http\Controllers\Admin\AdminBoatGuestController;
use App\Http\Controllers\Admin\AdminBoatGuestDatesController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminResetPasswordController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminServiceCategoryController;
use App\Http\Controllers\Admin\AdminMaterialController;
use App\Http\Controllers\Admin\AdminMaterialCategoryController;
use App\Http\Controllers\Admin\AdminServiceRequestController;

Auth::routes();
//dd(Route::getRoutes());

Route::group([
    'as'  => 'customer.',
],function () {
    Route::get('login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::post('login', [CustomerLoginController::class, 'login'])->name('login');
    Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');
});
Route::get('route/current/{guard}/{currentRouteName}/{route}', [RouteController::class, 'setCurrentMenu'])
    ->name('route.current')
    ->middleware(['auth:admin,customer'])
;
Route::get('', fn () => redirect('dashboard'));

Route::group([
    'prefix'    => 'customer',
    'as'        => 'customer.',
    'middleware' => ['auth:admin,customer'],
],function () {
    Route::resource('profile', ProfileController::class);
    Route::resource('boats', BoatController::class);
    Route::resource('boatDates', BoatDatesController::class);
    Route::resource('serviceRequests', ServiceRequestController::class);

    Route::get('boatDates/invoice/{boatDate}', [BoatDatesController::class, 'invoice'])->name('boatDates.invoice');
});

Route::group([
    'as'  => 'public.',
],function () {
    Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::resource('pages', PageController::class);
    Route::resource('widgets', WidgetController::class);
    Route::get('reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha'])->name('reload.captcha');
});
Route::group([
    'prefix'    => 'admin',
    'as'        => 'admin.',
],function () {
    Route::get('login', [AdminLoginController::class,'showLoginForm'])->name('login');
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
    Route::get('boatDates/invoice/{boatDate}', [AdminBoatDatesController::class, 'invoice'])->name('boatDates.invoice');
    Route::get('boatDates/sendInvoice/{boatDate}', [AdminBoatDatesController::class, 'sendInvoice'])->name('boatDates.sendInvoice');
    Route::get('boatDates/saison', [AdminBoatDatesController::class, 'saison'])->name('boatDates.saison');
    Route::get('boatDates/winter', [AdminBoatDatesController::class, 'winter'])->name('boatDates.winter');

    Route::match(['post','put'],'caravanDates/price/calculate', [AdminPriceController::class, 'calculateCaravanDates'])->name('caravanDates.price.calculate');
    Route::match(['post','put'],'boatDates/price/calculate', [AdminPriceController::class, 'calculateBoatDates'])->name('boatDates.price.calculate');
    Route::match(['post','put'],'guestBoatDates/price/calculate', [AdminPriceController::class, 'calculateGuestBoatDates'])->name('guestBoatDates.price.calculate');

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
    Route::resource('boatGuests', AdminBoatGuestController::class);
    Route::resource('boatGuestDates', AdminBoatGuestDatesController::class);
    Route::resource('services', AdminServiceController::class);
    Route::resource('serviceCategories', AdminServiceCategoryController::class);
    Route::resource('materials', AdminMaterialController::class);
    Route::resource('materialCategories', AdminMaterialCategoryController::class);
    Route::resource('serviceRequests', AdminServiceRequestController::class);

    Route::post('caravanDates/sendExcel', [AdminCaravanDatesController::class, 'sendExcel'])->name('caravanDates.sendExcel');

    Route::get('caravan/price/excel/{year?}/{month?}', [AdminPriceController::class, 'excel'])->name('caravan.price.excel');
    Route::get('caravan/price/pdf/{year?}/{month?}', [AdminPriceController::class, 'pdf'])->name('caravan.price.pdf');
    Route::get('car/info', [AdminCarLicensePlateController::class, 'info'])->name('car.info');
//    Route::get('route/current//{currentRouteName}', [RouteController::class, 'setCurrentMenu'])->name('route.current');
    Route::post('upload/image/{paramName}', [AdminUploadController::class, 'imageUpload'])->name('upload.image');

    Route::get('routes', [AdminInfoController::class, 'routes'])->name('infos.routes');
    Route::get('php', [AdminInfoController::class, 'phpinfo'])->name('infos.php');
    Route::fallback(function () {
//        return redirect('/admin');
        return 'wrong admin route';
    });
});

Route::fallback(function () {
    return redirect('');
});
