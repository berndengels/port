<?php
namespace Database\Seeders;

use App\Models\Boat;
use App\Models\BoatDates;
use Database\Seeders\Ext\MainTestSeeder;

class BoatTestSeeder extends MainTestSeeder
{
    protected $table = 'boats';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Boat::factory()
//            ->hasDates(3)
            ->count($this->count)
            ->create();
    }
}
