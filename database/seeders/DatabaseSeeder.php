<?php

namespace Database\Seeders;

use Eloquent;
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
        Eloquent::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
