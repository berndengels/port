<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Role;
use App\Repositories\Ext\SelectOptions;

class RoleRepository extends Repository
{
    use SelectOptions;

    protected static $model = Role::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_ROLE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_ROLE;

}
