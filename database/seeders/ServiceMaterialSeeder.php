<?php

namespace Database\Seeders;

use Database\Data\ServiceMaterialData;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceMaterialSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'service_materials';
    protected $dataClass = ServiceMaterialData::class;
}
