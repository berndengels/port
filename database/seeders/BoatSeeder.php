<?php
namespace Database\Seeders;

use App\Models\Boat;
use Database\Seeders\Ext\MainSeeder;

class BoatSeeder extends MainSeeder
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
            ->count($this->count)
            ->create();
    }
}
