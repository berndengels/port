<?php

namespace Database\Seeders;

use App\Models\Material;
use Database\Data\MaterialData;
use Database\Seeders\Ext\MainTestSeeder;

class MaterialTestSeeder extends MainTestSeeder
{
    protected $table = 'materials';
    protected $model = Material::class;
    protected $dataClass = MaterialData::class;
}
