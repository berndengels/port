<?php
namespace Database\Seeders;

use App\Models\Boat;
use Database\Seeders\Ext\MainTestSeeder;

class BoatSeeder extends MainTestSeeder
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
            ->hasServiceRequests(2)
            ->count(100)
            ->create();
    }
}
