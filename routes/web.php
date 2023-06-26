<?php

use App\Http\Controllers\Admin\AdminApartmentController;
use App\Http\Controllers\Admin\AdminApartmentModelController;
use App\Http\Controllers\Admin\AdminApartmentRentalsController;
use App\Http\Controllers\Admin\AdminBerthCategoryController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminDockController;
use App\Http\Controllers\Admin\AdminConfigEntityController;
use App\Http\Controllers\Admin\AdminConfigHolidayController;
use App\Http\Controllers\Admin\AdminConfigSettingsController;
use App\Http\Controllers\Admin\AdminConfigSaisonRentController;
use App\Http\Controllers\Admin\AdminConfigSaisonRentDatesController;
use App\Http\Controllers\Admin\AdminConfigServiceController;
use App\Http\Controllers\Admin\AdminBerthController;
use App\Http\Controllers\Admin\AdminHouseboatController;
use App\Http\Controllers\Admin\AdminHouseboatRentalsController;
use App\Http\Controllers\Admin\AdminHouseboatModelController;
use App\Http\Controllers\Admin\AdminHouseboatOwnerController;
use App\Http\Controllers\Admin\AdminHouseController;
use App\Http\Controllers\Admin\AdminHouseModelController;
use App\Http\Controllers\Admin\AdminHouseRentalsController;
use App\Http\Controllers\Admin\AdminInfoController;
use App\Http\Controllers\Admin\AdminConfigOfferController;
use App\Http\Controllers\Admin\AdminQrCodeController;
use App\Http\Controllers\Admin\AdminRentalsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AdminCraneDateController;
use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\BoatDatesController;
use App\Http\Controllers\BerthController;
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
use App\Http\Controllers\Admin\AdminAccessLogController;
use App\Http\Controllers\CraneDateController;

Auth::routes();

Route::get('', function() {
    if(auth('admin')->check()) {
        return redirect('admin');
    }
    elseif (auth('customer')->check()) {
        return redirect('customer');
    }
    else {
        return redirect('dashboard');
    }
});

Route::group([
    'as'  => 'public.',
],function () {
    Route::get('dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::resource('widgets', WidgetController::class);
    Route::resource('berths', BerthController::class);
    Route::get('reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha'])->name('reload.captcha');
    Route::get('pages/{slug}', [PageController::class,'show'])->name('pages');
    Route::get('rentals/reservation', fn() => view('public.rentals.index'))->name('rentals.reservation');
	Route::get('documentation', fn() => response()->download(public_path('docs').'/doku-portm.pdf'))->name('documentation');
    Route::resource('contacts', ContactController::class)->only(['show','create','store']);
});
/*
Route::group([
    'as'     => 'public.',
    'prefix' => 'rentals',
    'middleware' => ['web'],
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
*/
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

Route::group([
    'prefix'    => 'customer',
    'as'        => 'customer.',
    'middleware' => ['auth:customer'],
],function () {
    Route::get('', [DashboardController::class, 'show'])->name('dashboard');
    Route::resource('profile', ProfileController::class);
    Route::resource('boats', BoatController::class);
    Route::resource('boatDates', BoatDatesController::class);
    Route::resource('craneDates', CraneDateController::class);
    Route::resource('serviceRequests', ServiceRequestController::class);
    Route::get('boatDates/invoice/{boatDate}', [BoatDatesController::class, 'invoice'])->name('boatDates.invoice');
    Route::get('boatDates/print/{boatDate}', [BoatDatesController::class, 'printPage'])->name('boatDates.print');
    Route::get('serviceRequests/print/{serviceRequest}', [ServiceRequestController::class, 'printPage'])->name('serviceRequests.print');
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
    Route::get('', [AdminDashboardController::class, 'show'])->name('dashboard')->middleware(['check-settings']);
    Route::post('logout', [AdminLoginController::class,'logout'])->name('logout');

    Route::get('customers/guest', [AdminCustomerController::class,'guest'])->name('customers.guest');
    Route::get('customers/renter', [AdminCustomerController::class,'renter'])->name('customers.renter');

    Route::get('boats/guests', [AdminBoatController::class,'guests'])->name('boats.guests');
    Route::get('boatDates/invoice/{boatDate}', [AdminBoatDatesController::class, 'invoice'])->name('boatDates.invoice');

    Route::get('boatDates/index/summer', [AdminBoatDatesController::class, 'index'])->name('boatDates.summer');
    Route::get('boatDates/index/winter', [AdminBoatDatesController::class, 'index'])->name('boatDates.winter');

    Route::match(['post','put'],'caravanDates/price/calculate', [AdminPriceController::class, 'calculateCaravanPrices'])->name('caravanDates.price.calculate');
    Route::match(['post','put'],'boatDates/price/calculate', [AdminPriceController::class, 'calculateBoatPrices'])->name('boatDates.price.calculate');
    Route::match(['post','put'],'guestBoatDates/price/calculate', [AdminPriceController::class, 'calculateGuestBoatPrices'])->name('guestBoatDates.price.calculate');
    Route::match(['post','put'],'rentals/price/calculate', [AdminPriceController::class, 'calculateRentalPrices'])->name('rentals.price.calculate');

    Route::get('customers/create/{type}', [AdminCustomerController::class,'create'])->name('customers.create');
    Route::get('customers/guests', [AdminCustomerController::class,'guest'])->name('customers.guests');
    Route::get('customers/renters', [AdminCustomerController::class,'renter'])->name('customers.renters');

    Route::post('craneDates/cranable', [AdminCraneDateController::class, 'cranable'])->name('boatCraneDates.cranable');

    Route::resource('customers', AdminCustomerController::class)->except(['create']);
    Route::resource('contacts', AdminContactController::class)->only(['index','show','destroy']);
    Route::resource('caravans', AdminCaravanController::class);
    Route::resource('caravanDates', AdminCaravanDatesController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('roles', AdminRoleController::class);
    Route::resource('permissions', AdminPermissionController::class);
    Route::resource('pages', AdminPageController::class);
    Route::resource('widgets', AdminWidgetController::class);
    Route::resource('boats', AdminBoatController::class);
    Route::resource('boatDates', AdminBoatDatesController::class);
    Route::resource('craneDates', AdminCraneDateController::class);
    Route::resource('guestBoats', AdminGuestBoatController::class);
    Route::resource('houseboats', AdminHouseboatController::class);
    Route::resource('houseboatOwners', AdminHouseboatOwnerController::class);
    Route::resource('houseboatModels', AdminHouseboatModelController::class);
    Route::resource('houseboats', AdminHouseboatController::class);
    Route::resource('guestBoatDates', AdminGuestBoatDatesController::class);
    Route::resource('berths', AdminBerthController::class);
    Route::resource('berthCategories', AdminBerthCategoryController::class);
    Route::resource('services', AdminServiceController::class);
    Route::resource('serviceCategories', AdminServiceCategoryController::class);
    Route::resource('materials', AdminMaterialController::class);
    Route::resource('materialCategories', AdminMaterialCategoryController::class);
    Route::resource('serviceRequests', AdminServiceRequestController::class);
    Route::resource('docks', AdminDockController::class);
    Route::resource('apartments', AdminApartmentController::class);
    Route::resource('apartmentModels', AdminApartmentModelController::class);
    Route::resource('houses', AdminHouseController::class);
    Route::resource('houseModels', AdminHouseModelController::class);
    Route::resource('rentals', AdminRentalsController::class);
    Route::resource('accessLogs', AdminAccessLogController::class)->only(['index','show']);

    Route::group([
            'prefix' => 'config',
            'as'    => 'config.',
        ],
        function() {
            Route::get('saisonDates/guests', [AdminConfigSaisonDatesController::class,'guests'])->name('saisonDates.guests');
            Route::get('saisonDates/customers', [AdminConfigSaisonDatesController::class,'customers'])->name('saisonDates.customers');

            Route::resource('settings', AdminConfigSettingsController::class)->except(['show']);
            Route::resource('offers', AdminConfigOfferController::class);
            Route::resource('saisonDates', AdminConfigSaisonDatesController::class);
            Route::resource('boatPrices', AdminConfigBoatPriceController::class);
            Route::resource('dailyPrices', AdminConfigDailyPriceController::class);
            Route::resource('priceComponents', AdminConfigPriceComponentController::class);
            Route::resource('priceTypes', AdminConfigPriceTypeController::class);
            Route::resource('services', AdminConfigServiceController::class);
            Route::resource('entities', AdminConfigEntityController::class);
            Route::resource('saisonRents', AdminConfigSaisonRentController::class);
            Route::resource('saisonRentDates', AdminConfigSaisonRentDatesController::class);
            Route::resource('holidays', AdminConfigHolidayController::class)->only(['index']);
            Route::post('holidays/toggle/{configHoliday}', [AdminConfigHolidayController::class, 'toggle'])->name('holidays.toggle');
    });

//    Route::get('rentals/sendInvoice/{houseboatDate}', [AdminRentalsController::class, 'sendInvoice'])->name('rentals.sendInvoice');
//    Route::get('rentals/sendInvoice/{houseboatDate}', [AdminHouseboatRentalsController::class, 'sendInvoice'])->name('rentals.sendInvoice');
    Route::get('boatDates/sendInvoice/{boatDate}', [AdminBoatDatesController::class, 'sendInvoice'])->name('boatDates.sendInvoice');

    Route::get('caravanDates/print/{caravanDate}', [AdminCaravanDatesController::class, 'printPage'])->name('caravanDates.print');
    Route::get('caravanDates/sendInvoice/{caravanDate}', [AdminCaravanDatesController::class, 'sendInvoice'])->name('caravanDates.sendInvoice');
    Route::get('guestBoatDates/print/{guestBoatDate}', [AdminGuestBoatDatesController::class, 'printPage'])->name('guestBoatDates.print');
    Route::get('guestBoatDates/sendInvoice/{guestBoatDate}', [AdminGuestBoatDatesController::class, 'sendInvoice'])->name('guestBoatDates.sendInvoice');
    Route::get('boatDates/print/{boatDate}', [AdminBoatDatesController::class, 'printPage'])->name('boatDates.print');
//    Route::get('rentals/print/{houseboatDate}', [AdminHouseboatRentalsController::class, 'printPage'])->name('rentals.print');
    Route::get('serviceRequests/print/{serviceRequest}', [AdminServiceRequestController::class, 'printPage'])->name('serviceRequests.print');
//    Route::get('rentals/print/{rentable}', [AdminRentalsController::class, 'printPage'])->name('rentals.print');

    Route::post('offers/toggle/{offer}', [AdminConfigOfferController::class, 'toggle'])->name('offers.toggle');
    Route::post('caravanDates/toggle/{caravanDate}', [AdminCaravanDatesController::class, 'toggle'])->name('caravanDates.toggle');
    Route::post('boatDates/toggle/{boatDate}', [AdminBoatDatesController::class, 'toggle'])->name('boatDates.toggle');
    Route::post('guestBoatDates/toggle/{guestBoatDate}', [AdminGuestBoatDatesController::class, 'toggle'])->name('guestBoatDates.toggle');
    Route::post('berths/toggle/{berth}', [AdminBerthController::class, 'toggle'])->name('berths.toggle');
//    Route::post('rentals/toggle/{houseboatDate}', [AdminHouseboatRentalsController::class, 'toggle'])->name('rentals.toggle');
    Route::post('serviceRequests/toggle/{serviceRequest}', [AdminServiceRequestController::class, 'toggle'])->name('serviceRequests.toggle');
//    Route::post('rentals/toggle/{rentable}', [AdminRentalsController::class, 'toggle'])->name('rentals.toggle');

    Route::post('serviceRequests/done/{serviceRequest}', [AdminServiceRequestController::class, 'done'])->name('serviceRequests.done');

    Route::post('caravanDates/sendExcel', [AdminCaravanDatesController::class, 'sendExcel'])->name('caravanDates.sendExcel');
    Route::post('boatDates/sendExcel', [AdminBoatDatesController::class, 'sendExcel'])->name('boatDates.sendExcel');
    Route::post('guestBoatDates/sendExcel', [AdminGuestBoatDatesController::class, 'sendExcel'])->name('guestBoatDates.sendExcel');
//    Route::post('houseBoatDates/sendExcel', [AdminHouseboatRentalsController::class, 'sendExcel'])->name('rentals.sendExcel');
//    Route::post('rentals/sendExcel', [AdminRentalsController::class, 'sendExcel'])->name('rentals.sendExcel');

    Route::get('caravan/price/excel/{from?}/{until?}', [AdminPriceController::class, 'excelCaravanDates'])->name('caravan.price.excel');
    Route::get('boat/price/excel/{from?}/{until?}', [AdminPriceController::class, 'excelBoatDates'])->name('boat.price.excel');
    Route::get('guestBoat/price/excel/{from?}/{until?}', [AdminPriceController::class, 'excelGuestBoatDates'])->name('guestBoat.price.excel');
    Route::get('rentals/price/excel/{rentable}/{from?}/{until?}', [AdminPriceController::class, 'excelRentalDates'])->name('rentals.price.excel');

    Route::get('caravan/price/pdf/{from?}/{until?}', [AdminPriceController::class, 'pdfCaravanDates'])->name('caravan.price.pdf');
    Route::get('baot/price/pdf/{from?}/{until?}', [AdminPriceController::class, 'pdfBoatDates'])->name('boat.price.pdf');
    Route::get('guestBoat/price/pdf/{from?}/{until?}', [AdminPriceController::class, 'pdfGuestBoatDates'])->name('guestBoat.price.pdf');
//    Route::get('houseBoat/price/pdf/{year?}/{month?}', [AdminPriceController::class, 'pdfHouseBoatDates'])->name('houseboat.price.pdf');

    Route::get('car/info', [AdminCarLicensePlateController::class, 'info'])->name('car.info');
//    Route::get('route/current//{currentRouteName}', [RouteController::class, 'setCurrentMenu'])->name('route.current');
    Route::match(['post','put'], 'upload/image/{boat}', [AdminUploadController::class, 'imageUpload'])->name('upload.image.boat');

    Route::get('routes', [AdminInfoController::class, 'routes'])->name('infos.routes');
    Route::get('php', [AdminInfoController::class, 'phpinfo'])->name('infos.php');
    Route::get('qrcode', [AdminQrCodeController::class, 'index'])->name('qrcode');

    Route::fallback(function () {
        if(!app()->environment('production')) {
            return 'wrong admin route';
        } else {
        return redirect('/admin');
        }
    });
});


Route::group([
    'as'         => 'admin.',
    'prefix'     => 'admin',
    'middleware' => ['auth:admin'],
], function () {
    Route::get('houseRentals/{rental}',[AdminHouseRentalsController::class,'show'])->name('houseRentals.show');
    Route::get('houseRentals/edit/{rental}',[AdminHouseRentalsController::class,'edit'])->name('houseRentals.edit');
    Route::post('houseRentals',[AdminHouseRentalsController::class,'create'])->name('houseRentals.create');
    Route::get('houseRentals/print/{rental}',[AdminHouseRentalsController::class,'printPage'])->name('houseRentals.print');
    Route::post('houseRentals/excel/{rentable}',[AdminHouseRentalsController::class,'sendExcel'])->name('houseRentals.sendExcel');
    Route::get('houseRentals/excel/{rental}',[AdminHouseRentalsController::class,'sendInvoice'])->name('houseRentals.sendInvoice');
    Route::post('houseRentals/toggle/{rental}', [AdminHouseRentalsController::class, 'toggle'])->name('houseRentals.toggle');
    Route::post('houseRentals',[AdminHouseRentalsController::class,'store'])->name('houseRentals.store');
    Route::put('houseRentals/{rental}',[AdminHouseRentalsController::class,'update'])->name('houseRentals.update');
    Route::delete('houseRentals/{rental}',[AdminHouseRentalsController::class,'destroy'])->name('houseRentals.destroy');
    Route::resource('houseRentals', AdminHouseRentalsController::class)->only(['index','create']);

    Route::get('houseboatRentals/{rental}',[AdminHouseboatRentalsController::class,'show'])->name('houseboatRentals.show');
    Route::get('houseboatRentals/edit/{rental}',[AdminHouseboatRentalsController::class,'edit'])->name('houseboatRentals.edit');
    Route::post('houseboatRentals',[AdminHouseboatRentalsController::class,'create'])->name('houseboatRentals.create');
    Route::get('houseboatRentals/print/{rental}',[AdminHouseboatRentalsController::class,'printPage'])->name('houseboatRentals.print');
    Route::get('houseboatRentals/sendInvoice/{rental}',[AdminHouseboatRentalsController::class,'sendInvoice'])->name('houseboatRentals.sendInvoice');
    Route::post('houseboatRentals/excel/{rentable}',[AdminHouseboatRentalsController::class,'sendExcel'])->name('houseboatRentals.sendExcel');
    Route::post('houseboatRentals/toggle/{rental}', [AdminHouseboatRentalsController::class, 'toggle'])->name('houseboatRentals.toggle');
    Route::post('houseboatRentals',[AdminHouseboatRentalsController::class,'store'])->name('houseboatRentals.store');
    Route::put('houseboatRentals/{rental}',[AdminHouseboatRentalsController::class,'update'])->name('houseboatRentals.update');
    Route::delete('houseboatRentals/{rental}',[AdminHouseboatRentalsController::class,'destroy'])->name('houseboatRentals.destroy');
    Route::resource('houseboatRentals', AdminHouseboatRentalsController::class)->only(['index','create']);

    Route::get('apartmentRentals/{rental}',[AdminApartmentRentalsController::class,'show'])->name('apartmentRentals.show');
    Route::get('apartmentRentals/edit/{rental}',[AdminApartmentRentalsController::class,'edit'])->name('apartmentRentals.edit');
    Route::post('apartmentRentals',[AdminApartmentRentalsController::class,'create'])->name('apartmentRentals.create');
    Route::get('apartmentRentals/print/{rental}',[AdminApartmentRentalsController::class,'printPage'])->name('apartmentRentals.print');
    Route::get('apartmentRentals/sendInvoice/{rental}',[AdminApartmentRentalsController::class,'sendInvoice'])->name('apartmentRentals.sendInvoice');
    Route::post('apartmentRentals/excel/{rentable}',[AdminApartmentRentalsController::class,'sendExcel'])->name('apartmentRentals.sendExcel');
    Route::post('apartmentRentals/toggle/{rental}', [AdminApartmentRentalsController::class, 'toggle'])->name('apartmentRentals.toggle');
    Route::post('apartmentRentals',[AdminApartmentRentalsController::class,'store'])->name('apartmentRentals.store');
    Route::put('apartmentRentals/{rental}',[AdminApartmentRentalsController::class,'update'])->name('apartmentRentals.update');
    Route::delete('apartmentRentals/{rental}',[AdminApartmentRentalsController::class,'destroy'])->name('apartmentRentals.destroy');
    Route::resource('apartmentRentals', AdminApartmentRentalsController::class)->only(['index','create']);
});


Route::fallback(function () {
    return redirect('');
});
