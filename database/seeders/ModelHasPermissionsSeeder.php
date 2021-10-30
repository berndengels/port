<?php
namespace Database\Seeders;

use Database\Seeders\Ext\MainSeeder;
use Database\Data\ModelHasPermissionsData;

class ModelHasPermissionsSeeder extends MainSeeder
{
    protected $table = 'model_has_permissions';
    protected $dataClass = ModelHasPermissionsData::class;
}
