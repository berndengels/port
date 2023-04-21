<?php

namespace Database\Seeders;

use App\Models\BerthMap;
use Database\Data\BerthMapData;
use Database\Seeders\Ext\MainTestSeeder;

class BerthMapSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'berth_maps';
    protected $dataClass = BerthMapData::class;
}
