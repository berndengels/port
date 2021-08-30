<?php

namespace Database\Seeders;

use App\Models\Caravan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CaravanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Caravan::truncate();
        Caravan::factory()
            ->count(50)
            ->create()
        ;
    }
}
