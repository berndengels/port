<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
                    RoleTestSeeder::class,
                    PermissionTestSeeder::class,
                    RoleHasPermissionsTestSeeder::class,
                    CountryTestSeeder::class,
                    CarLicensePlateTestSeeder::class,
                    SaisonDatesSeeder::class,
                ]);
                break;
            case 'dusk.local':
            case 'demo':
                $this->call([
//                    RoleTestSeeder::class,
                    PermissionTestSeeder::class,
//                    ModelHasPermissionsTestSeeder::class,
//                    RoleHasPermissionsTestSeeder::class,
                    AdminUserTestSeeder::class,
                    CountryTestSeeder::class,
                    CarLicensePlateTestSeeder::class,
                    PagesTestSeeder::class,
                    WidgetTestSeeder::class,
                    CaravanTestSeeder::class,
                    GuestBoatTestSeeder::class,
                    CustomerTestSeeder::class,
                    PriceTypeTestSeeder::class,
                    MaterialCategoryTestSeeder::class,
                    ServiceCategoryTestSeeder::class,
                    MaterialTestSeeder::class,
                    ServiceTestSeeder::class,
                    ServiceMaterialTestSeeder::class,
                    ServiceRequestTestSeeder::class,
                ]);
                break;
            default:
                $this->call([]);
        }
    }
}
