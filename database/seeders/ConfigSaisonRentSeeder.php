<?php

namespace Database\Seeders;

use Database\Data\ConfigSaisonRentData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigSaisonRentSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_saison_rents';
    protected $dataClass = ConfigSaisonRentData::class;
}
