<?php

namespace Database\Seeders;

use App\Models\ConfigEntityType;
use Database\Data\ConfigEntityTypeData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigEntityTypeTestSeeder extends MainTestSeeder
{
    protected $table = 'config_entity_types';
    protected $model = ConfigEntityType::class;
    protected $dataClass = ConfigEntityTypeData::class;
}
