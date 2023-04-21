<?php

namespace Database\Seeders;

use App\Models\Berth;
use Database\Data\BerthData;
use Database\Seeders\Ext\MainTestSeeder;

class BerthSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'berths';
    protected $dataClass = BerthData::class;
}
