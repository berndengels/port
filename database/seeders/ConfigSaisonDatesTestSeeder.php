<?php

namespace Database\Seeders;

use App\Models\ConfigSaisonDates;
use Database\Data\ConfigSaisonDateData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigSaisonDatesTestSeeder extends MainTestSeeder
{
    protected $table = 'config_saison_dates';
    protected $model = ConfigSaisonDates::class;
    protected $dataClass = ConfigSaisonDateData::class;
}
