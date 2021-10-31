<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        DB::setDefaultConnection('demo');
        $this->call([
            RoleTestSeeder::class,
            PermissionTestSeeder::class,
            ModelHasPermissionsTestSeeder::class,
            RoleHasPermissionsTestSeeder::class,
            AdminUserTestSeeder::class,
            CountryTestSeeder::class,
            CarLicensePlateTestSeeder::class,
            PagesTestSeeder::class,
            WidgetTestSeeder::class,
            CaravanTestSeeder::class,
            BoatGuestTestSeeder::class,
            CustomerTestSeeder::class,
        ]);
    }
}
