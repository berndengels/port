<?php

namespace Database\Seeders;

use App\Models\ConfigSaisonDates;
use Database\Seeders\Ext\MainTestSeeder;

class SaisonDatesSeeder extends MainTestSeeder
{
    protected $table = 'saison_dates';
    protected $model = ConfigSaisonDates::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigSaisonDates::factory()->count(2)->create();
    }
}
