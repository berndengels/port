<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleTestSeeder::class,
            PermissionTestSeeder::class,
            ModelHasPermissionsTestSeeder::class,
            RoleHasPermissionsTestSeeder::class,
            CustomerTestSeeder::class,
            AdminUserTestSeeder::class,
            CountryTestSeeder::class,
            CarLicensePlateTestSeeder::class,
            PagesTestSeeder::class,
            WidgetTestSeeder::class,
            CaravanTestSeeder::class,
            CaravanDatesTestSeeder::class,
            BoatGuestTestSeeder::class,
            BoatGuestDatesTestSeeder::class,
            BoatTestSeeder::class,
            BoatDatesTestSeeder::class,
        ]);
    }
}
