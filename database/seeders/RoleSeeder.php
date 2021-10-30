<?php
namespace Database\Seeders;

use App\Models\Role;
use Database\Seeders\Ext\MainSeeder;

class RoleSeeder extends MainSeeder
{
    protected $table = 'roles';
    protected $model = Role::class;

}
