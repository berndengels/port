<?php
namespace Database\Seeders;

use App\Models\Boat;
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
            ->connection('test')
            ->count($this->count)
            ->create();
    }
}
