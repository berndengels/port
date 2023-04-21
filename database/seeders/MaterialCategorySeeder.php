<?php

namespace Database\Seeders;

use Database\Data\MaterialCategoryData;
use Database\Seeders\Ext\MainTestSeeder;

class MaterialCategorySeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'material_categories';
    protected $dataClass = MaterialCategoryData::class;
}
