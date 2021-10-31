<?php
namespace Database\Seeders;

use Database\Seeders\Ext\MainTestSeeder;
use Database\Data\ModelHasPermissionsData;

class ModelHasPermissionsTestSeeder extends MainTestSeeder
{
    protected $table = 'model_has_permissions';
    protected $dataClass = ModelHasPermissionsData::class;
}
