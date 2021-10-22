<?php
namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Ext\SelectOptions;

class RoleRepository extends Repository
{
    use SelectOptions;

    protected static $model = Role::class;

}
