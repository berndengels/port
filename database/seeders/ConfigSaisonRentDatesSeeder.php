<?php

namespace Database\Seeders;

use Database\Data\ConfigSaisonRentDateData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigSaisonRentDatesSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_saison_rent_dates';
    protected $dataClass = ConfigSaisonRentDateData::class;
}
