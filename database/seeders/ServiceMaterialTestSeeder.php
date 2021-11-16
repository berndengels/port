<?php

namespace Database\Seeders;

use App\Models\Service;
use Database\Data\ServiceMaterialData;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceMaterialTestSeeder extends MainTestSeeder
{
    protected $table = 'service_materials';
    protected $dataClass = ServiceMaterialData::class;
}
