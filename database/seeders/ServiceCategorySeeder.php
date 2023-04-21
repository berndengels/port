<?php

namespace Database\Seeders;

use Database\Data\ServiceCategoryData;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceCategorySeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'service_categories';
    protected $dataClass = ServiceCategoryData::class;
}
