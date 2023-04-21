<?php

namespace Database\Seeders;

use Database\Data\ConfigSettingData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigSettingsSeeder extends MainTestSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $truncate = true;
    protected $table = 'config_settings';
    protected $dataClass = ConfigSettingData::class;
}
