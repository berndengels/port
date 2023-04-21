<?php

namespace Database\Seeders;

use Database\Data\ServiceData;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'services';
    protected $dataClass = ServiceData::class;
}
