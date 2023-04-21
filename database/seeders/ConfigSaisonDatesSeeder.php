<?php

namespace Database\Seeders;

use Database\Data\ConfigSaisonDateData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigSaisonDatesSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_saison_dates';
    protected $dataClass = ConfigSaisonDateData::class;
}
