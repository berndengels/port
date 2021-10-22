<?php

namespace Database\Seeders;

use App\Models\AdminUser;
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
            RoleSeeder::class,
            PermissionSeeder::class,
            ModelHasPermissionsSeeder::class,
            RoleHasPermissionsSeeder::class,
            CustomerSeeder::class,
            AdminUserSeeder::class,
            CountrySeeder::class,
            CarLicensePlateSeeder::class,
            PagesSeeder::class,
            WidgetSeeder::class,
            CaravanSeeder::class,
            CaravanDatesSeeder::class,
            BoatSeeder::class,
            BoatDatesSeeder::class,
            BoatGuestSeeder::class,
            BoatGuestDatesSeeder::class,
        ]);
    }
}
