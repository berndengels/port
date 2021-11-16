<?php

namespace Database\Seeders;

use App\Models\MaterialCategory;
use Database\Data\MaterialCategoryData;
use Database\Seeders\Ext\MainTestSeeder;

class MaterialCategoryTestSeeder extends MainTestSeeder
{
    protected $table = 'material_categories';
    protected $model = MaterialCategory::class;
    protected $dataClass = MaterialCategoryData::class;
}
