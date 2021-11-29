<?php

namespace Database\Seeders;

use App\Models\SaisonDates;
use Database\Seeders\Ext\MainTestSeeder;

class SaisonDatesSeeder extends MainTestSeeder
{
    protected $table = 'saison_dates';
    protected $model = SaisonDates::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SaisonDates::factory()->count(2)->create();
    }
}
