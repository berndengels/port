<?php

namespace Database\Seeders;

use App\Models\Manydata;
use Illuminate\Database\Seeder;

class ManydataSeeder extends Seeder
{
    private $count = 2000000;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manydata::factory()
            ->count($this->count)
            ->create()
        ;
    }
}
