<?php

use App\Http\Controllers\Admin\AdminConfigEntityTypeController;
use App\Http\Controllers\Admin\AdminConfigSaisonRentController;
use App\Http\Controllers\Admin\AdminConfigSaisonRentDatesController;
use App\Http\Controllers\Admin\AdminConfigServiceController;
use App\Http\Controllers\Admin\AdminGuestBoatBerthController;
use App\Http\Controllers\Admin\AdminHouseboatController;
use App\Http\Controllers\Admin\AdminHouseboatDatesController;
use App\Http\Controllers\Admin\AdminHouseboatModelController;
use App\Http\Controllers\Admin\AdminHouseboatOwnerController;
use App\Http\Controllers\Admin\AdminInfoController;
use App\Http\Controllers\Admin\AdminConfigOfferController;
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
use App\Http\Controllers\Admin\AdminGuestBoatController;
use App\Http\Controllers\Admin\AdminGuestBoatDatesController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminResetPasswordController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminServiceCategoryController;
use App\Http\Controllers\Admin\AdminMaterialController;
use App\Http\Controllers\Admin\AdminMaterialCategoryController;
use App\Http\Controllers\Admin\AdminServiceRequestController;
use App\Http\Controllers\Admin\AdminConfigBoatPriceController;
use App\Http\Controllers\Admin\AdminConfigDailyPriceController;
use App\Http\Controllers\Admin\AdminConfigPriceComponentController;
use App\Http\Controllers\Admin\AdminConfigPriceTypeController;
use App\Http\Controllers\Admin\AdminConfigSaisonDatesController;
use App\Http\Controllers\Admin\AdminHolydayController;

Auth::routes();

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
    Route::get('signin/{customerId}', [CustomerLoginController::class, 'signin'])->name('signin')
        ->middleware('signed')
    ;
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
    Route::get('customers/houseboats', [AdminCustomerController::class,'houseboats'])->name('customers.houseboats');
    Route::get('customers/tinyhouses', [AdminCustomerController::class,'tinyhouses'])->name('customers.tinyhouses');

    Route::get('boats/guests', [AdminBoatController::class,'guests'])->name('boats.guests');
    Route::get('boatDates/invoice/{boatDate}', [AdminBoatDatesController::class, 'invoice'])->name('boatDates.invoice');
    Route::get('boatDates/sendInvoice/{boatDate}', [AdminBoatDatesController::class, 'sendInvoice'])->name('boatDates.sendInvoice');

    Route::get('boatDates/index/summer', [AdminBoatDatesController::class, 'index'])->name('boatDates.summer');
    Route::get('boatDates/index/winter', [AdminBoatDatesController::class, 'index'])->name('boatDates.winter');

    Route::match(['post','put'],'caravanDates/price/calculate', [AdminPriceController::class, 'calculateCaravanDates'])->name('caravanDates.price.calculate');
    Route::match(['post','put'],'boatDates/price/calculate', [AdminPriceController::class, 'calculateBoatDates'])->name('boatDates.price.calculate');
    Route::match(['post','put'],'guestBoatDates/price/calculate', [AdminPriceController::class, 'calculateGuestBoatDates'])->name('guestBoatDates.price.calculate');
    Route::match(['post','put'],'houseboatDates/price/calculate', [AdminPriceController::class, 'calculateHouseboatDates'])->name('houseboatDates.price.calculate');

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
    Route::resource('guestBoats', AdminGuestBoatController::class);
    Route::resource('houseboats', AdminHouseboatController::class);
    Route::resource('houseboatOwners', AdminHouseboatOwnerController::class);
    Route::resource('houseboatModels', AdminHouseboatModelController::class);
    Route::resource('houseboats', AdminHouseboatController::class);
    Route::resource('houseboatDates', AdminHouseboatDatesController::class);
    Route::resource('guestBoatDates', AdminGuestBoatDatesController::class);
    Route::resource('guestBoatBerths', AdminGuestBoatBerthController::class);
    Route::resource('services', AdminServiceController::class);
    Route::resource('serviceCategories', AdminServiceCategoryController::class);
    Route::resource('materials', AdminMaterialController::class);
    Route::resource('materialCategories', AdminMaterialCategoryController::class);
    Route::resource('serviceRequests', AdminServiceRequestController::class);

    Route::group([
            'prefix' => 'config',
            'as'    => 'config.',
        ],
        function() {
            Route::resource('offers', AdminConfigOfferController::class);
            Route::resource('saisonDates', AdminConfigSaisonDatesController::class);
            Route::resource('boatPrices', AdminConfigBoatPriceController::class);
            Route::resource('dailyPrices', AdminConfigDailyPriceController::class);
            Route::resource('priceComponents', AdminConfigPriceComponentController::class);
            Route::resource('priceTypes', AdminConfigPriceTypeController::class);
            Route::resource('services', AdminConfigServiceController::class);
            Route::resource('entityTypes', AdminConfigEntityTypeController::class);
            Route::resource('saisonRents', AdminConfigSaisonRentController::class);
            Route::resource('saisonRentDates', AdminConfigSaisonRentDatesController::class);
    });

    Route::get('houseboatDates/sendInvoice/{houseboatDate}', [AdminHouseboatDatesController::class, 'sendInvoice'])->name('houseboatDates.sendInvoice');
    Route::get('houseboatDates/print/{houseboatDate}', [AdminHouseboatDatesController::class, 'printPage'])->name('houseboatDates.print');

    Route::post('offers/toggle/{offer}', [AdminConfigOfferController::class, 'toggle'])->name('offers.toggle');
    Route::post('caravanDates/toggle/{caravanDate}', [AdminCaravanDatesController::class, 'toggle'])->name('caravanDates.toggle');
    Route::post('boatDates/toggle/{boatDate}', [AdminBoatDatesController::class, 'toggle'])->name('boatDates.toggle');
    Route::post('guestBoatDates/toggle/{guestBoatDate}', [AdminGuestBoatDatesController::class, 'toggle'])->name('guestBoatDates.toggle');
    Route::post('guestBoatBerths/toggle/{guestBoatBerth}', [AdminGuestBoatBerthController::class, 'toggle'])->name('guestBoatBerths.toggle');
    Route::post('houseboatDates/toggle/{houseboatDate}', [AdminHouseboatDatesController::class, 'toggle'])->name('houseboatDates.toggle');

    Route::post('serviceRequests/done/{serviceRequest}', [AdminServiceRequestController::class, 'done'])->name('serviceRequests.done');

    Route::post('caravanDates/sendExcel', [AdminCaravanDatesController::class, 'sendExcel'])->name('caravanDates.sendExcel');
    Route::post('boatDates/sendExcel', [AdminBoatDatesController::class, 'sendExcel'])->name('boatDates.sendExcel');
    Route::post('guestBoatDates/sendExcel', [AdminGuestBoatDatesController::class, 'sendExcel'])->name('guestBoatDates.sendExcel');

    Route::get('caravan/price/excel/{year?}/{month?}', [AdminPriceController::class, 'excelCaravanDates'])->name('caravan.price.excel');
    Route::get('caravan/price/pdf/{year?}/{month?}', [AdminPriceController::class, 'pdfCaravanDates'])->name('caravan.price.pdf');

    Route::get('boat/price/excel/{year?}/{month?}', [AdminPriceController::class, 'excelBoatDates'])->name('boat.price.excel');
    Route::get('baot/price/pdf/{year?}/{month?}', [AdminPriceController::class, 'pdfBoatDates'])->name('boat.price.pdf');

    Route::get('guestBoat/price/excel/{year?}/{month?}', [AdminPriceController::class, 'excelGuestBoatDates'])->name('guestBoat.price.excel');
    Route::get('guestBoat/price/pdf/{year?}/{month?}', [AdminPriceController::class, 'pdfGuestBoatDates'])->name('guestBoat.price.pdf');

    Route::get('car/info', [AdminCarLicensePlateController::class, 'info'])->name('car.info');
//    Route::get('route/current//{currentRouteName}', [RouteController::class, 'setCurrentMenu'])->name('route.current');
    Route::post('upload/image/{paramName}', [AdminUploadController::class, 'imageUpload'])->name('upload.image');

    Route::get('routes', [AdminInfoController::class, 'routes'])->name('infos.routes');
    Route::get('php', [AdminInfoController::class, 'phpinfo'])->name('infos.php');
    Route::get('emojis', [AdminInfoController::class, 'emojis'])->name('infos.emojis');
    Route::get('holiday', [AdminHolydayController::class, 'index'])->name('holiday.index');

    Route::fallback(function () {
//        return redirect('/admin');
        return 'wrong admin route';
    });
});

Route::fallback(function () {
    return redirect('');
});
