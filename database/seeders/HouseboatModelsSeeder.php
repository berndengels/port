<?php

namespace Database\Seeders;

use Database\Data\HouseboatModelData;
use Database\Seeders\Ext\MainTestSeeder;

class HouseboatModelsSeeder extends MainTestSeeder
{
    protected $table = 'houseboat_models';
    protected $dataClass = HouseboatModelData::class;
}
