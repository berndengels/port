<?php
namespace Database\Seeders;

use Database\Data\ConfigHolidayData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigHolidayTestSeeder extends MainTestSeeder
{
    protected $table = 'config_holidays';
    protected $dataClass = ConfigHolidayData::class;
}
