<?php
namespace Database\Seeders;

use Database\Data\ModelHasRoleData;
use Database\Seeders\Ext\MainTestSeeder;
use Database\Data\ModelHasPermissionsData;

class ModelHasRolesTestSeeder extends MainTestSeeder
{
    protected $table = 'model_has_roles';
    protected $dataClass = ModelHasRoleData::class;
}
