<?php
namespace Database\Seeders;

use Database\Data\HouseboatOwnerData;
use Illuminate\Database\Seeder;
use function Pest\Laravel\delete;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        switch(config('app.env')) {
            case 'testing':
                $this->call([
                    BerthMapSeeder::class,
                    BerthSeeder::class,
                    RoleSeeder::class,
                    PermissionSeeder::class,
                    RoleHasPermissionsSeeder::class,
                    ModelHasRolesSeeder::class,
                    CountrySeeder::class,
                    CarLicensePlateSeeder::class,
                    ConfigHolidaySeeder::class,
                    ConfigSettingsSeeder::class,
                    ConfigEntitySeeder::class,
                    ConfigServiceSeeder::class,
                    ConfigPriceTypeSeeder::class,
                    ConfigSaisonDatesSeeder::class,
                    ConfigSaisonRentDatesSeeder::class,
                    ConfigBoatPriceSeeder::class,
                    ConfigDailyPriceSeeder::class,
                    ConfigPriceComponentSeeder::class,
                    ConfigHasPriceComponentSeeder::class,
                    ConfigOfferSeeder::class,
                    CaravanSeeder::class,
                    CaravanDatesSeeder::class,
                ]);
                break;
            case 'setup':
                $this->call([
                    BerthCategorySeeder::class,
                    RoleSeeder::class,
                    PermissionSeeder::class,
                    RoleHasPermissionsSeeder::class,
                    ModelHasRolesSeeder::class,
                    CountrySeeder::class,
                    CarLicensePlateSeeder::class,
                    MaterialSeeder::class,
                    MaterialCategorySeeder::class,
                    ServiceSeeder::class,
                    ServiceMaterialSeeder::class,
                    ConfigHolidaySeeder::class,
                    ConfigEntitySeeder::class,
                    ConfigServiceSeeder::class,
                    ConfigPriceTypeSeeder::class,
                    ConfigSaisonRentSeeder::class,
                    ConfigSaisonDatesSeeder::class,
                    ConfigSaisonRentDatesSeeder::class,
                    ConfigBoatPriceSeeder::class,
                    ConfigDailyPriceSeeder::class,
                    ConfigPriceComponentSeeder::class,
                    ConfigHasPriceComponentSeeder::class,
                    ConfigOfferSeeder::class,
                    ServiceSeeder::class,
                    AdminUserSeeder::class,
                ]);
                break;
            case 'dusk.local':
            case 'demo':
                $this->call([
                    RoleSeeder::class,
                    PermissionSeeder::class,
                    ModelHasPermissionsSeeder::class,
                    RoleHasPermissionsSeeder::class,
                    ModelHasRolesSeeder::class,
                    ConfigSettingsSeeder::class,
                    ConfigEntitySeeder::class,
                    ConfigServiceSeeder::class,
                    ConfigPriceTypeSeeder::class,
                    ConfigSaisonDatesSeeder::class,
                    ConfigSaisonRentDatesSeeder::class,
                    ConfigBoatPriceSeeder::class,
                    ConfigDailyPriceSeeder::class,
                    ConfigPriceComponentSeeder::class,
                    ConfigHasPriceComponentSeeder::class,
                    ConfigOfferSeeder::class,
                    DockSeeder::class,
                    BerthSeeder::class,
                    BerthMapSeeder::class,
                    AdminUserSeeder::class,
                    CountrySeeder::class,
                    CarLicensePlateSeeder::class,
                    PagesSeeder::class,
                    WidgetSeeder::class,
                    CaravanSeeder::class,
                    CaravanDatesSeeder::class,
                    CustomerSeeder::class,
//                    BoatSeeder::class,
//                    BoatDatesSeeder::class,
                    GuestBoatSeeder::class,
//                    GuestBoatDatesSeeder::class,
                    ConfigPriceTypeSeeder::class,
                    MaterialCategorySeeder::class,
                    ServiceCategorySeeder::class,
                    MaterialSeeder::class,
                    ServiceSeeder::class,
                    ServiceMaterialSeeder::class,
                    ServiceRequestSeeder::class,
                    HouseboatOwnerSeeder::class,
                    HouseboatModelsSeeder::class,
                    HouseboatSeeder::class,
                    HouseboatDatesSeeder::class,
                ]);
                break;
            default:
                $this->call([]);
        }
    }
}
