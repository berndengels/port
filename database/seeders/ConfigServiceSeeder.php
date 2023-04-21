<?php

namespace Database\Seeders;

use Database\Data\ConfigServiceData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigServiceSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_services';
    protected $dataClass = ConfigServiceData::class;
}
