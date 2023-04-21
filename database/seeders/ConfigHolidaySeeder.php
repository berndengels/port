<?php
namespace Database\Seeders;

use Database\Data\ConfigHolidayData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigHolidaySeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_holidays';
    protected $dataClass = ConfigHolidayData::class;
}
