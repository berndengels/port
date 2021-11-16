<?php

namespace Database\Seeders;

use App\Models\Service;
use Database\Data\ServiceData;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceTestSeeder extends MainTestSeeder
{
    protected $table = 'services';
    protected $model = Service::class;
    protected $dataClass = ServiceData::class;
}
