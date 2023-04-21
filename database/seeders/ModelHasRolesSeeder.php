<?php
namespace Database\Seeders;

use Database\Data\ModelHasRoleData;
use Database\Seeders\Ext\MainTestSeeder;

class ModelHasRolesSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'model_has_roles';
    protected $dataClass = ModelHasRoleData::class;
}
