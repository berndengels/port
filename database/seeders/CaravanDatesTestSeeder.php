<?php
namespace Database\Seeders;

use App\Models\CaravanDates;
use Database\Seeders\Ext\MainTestSeeder;

class CaravanDatesTestSeeder extends MainTestSeeder
{
    protected $count = 50;
    protected $table = 'caravan_dates';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CaravanDates::factory()
            ->connection('test')
            ->count($this->count)
            ->create()
        ;
    }
}
