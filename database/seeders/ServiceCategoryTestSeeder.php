<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Database\Data\ServiceCategoryData;
use Database\Seeders\Ext\MainTestSeeder;

class ServiceCategoryTestSeeder extends MainTestSeeder
{
    protected $table = 'service_categories';
    protected $model = ServiceCategory::class;
    protected $dataClass = ServiceCategoryData::class;
}
