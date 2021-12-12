<?php

namespace Database\Seeders;

use App\Models\ConfigService;
use Database\Data\ConfigServiceData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigServiceTestSeeder extends MainTestSeeder
{
    protected $table = 'config_services';
    protected $model = ConfigService::class;
    protected $dataClass = ConfigServiceData::class;
}
