<?php
namespace Database\Seeders;

use Database\Seeders\Ext\MainTestSeeder;
use Database\Data\ModelHasPermissionsData;

class ModelHasPermissionsSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'model_has_permissions';
    protected $dataClass = ModelHasPermissionsData::class;
}
