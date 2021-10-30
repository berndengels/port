<?php
namespace Database\Seeders;

use App\Models\CaravanDates;
use Database\Seeders\Ext\MainSeeder;

class CaravanDatesSeeder extends MainSeeder
{
    protected $count = 100;
    protected $table = 'caravan_dates';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaravanDates::factory()
            ->count($this->count)
            ->create()
        ;
    }
}
