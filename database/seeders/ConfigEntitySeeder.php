<?php

namespace Database\Seeders;

use Database\Data\ConfigEntityData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigEntitySeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_entities';
    protected $dataClass = ConfigEntityData::class;
}
