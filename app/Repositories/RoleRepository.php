<?php

namespace App\Repositories;

use App\Models\Role;
use App\Libs\AppCache;
use App\Repositories\Ext\SelectOptions;
use Illuminate\Database\Eloquent\Builder;

class RoleRepository extends Repository
{
    use SelectOptions;

    protected static $model = Role::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_ROLE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_ROLE;
    protected $guardName = null;

    public function setGuardName($name)
    {
        $this->guardName = $name;
        switch($name) {
            case 'admin':
                static::$cacheKeyOptions = AppCache::KEY_OPTIONS_ADMIN_ROLE;
                static::$cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_ADMIN_ROLE;
                break;
            case 'customer':
                static::$cacheKeyOptions = AppCache::KEY_OPTIONS_CUSTOMER_ROLE;
                static::$cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CUSTOMER_ROLE;
                break;
            case 'web':
            default:
                static::$cacheKeyOptions = AppCache::KEY_OPTIONS_WEB_ROLE;
                static::$cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_WEB_ROLE;
                break;
        }
        return $this;
    }

    public function getOptionsData($orderBy = 'name', $relations = [])
    {
        $query = Role::orderBy('name');
        if($this->guardName) {
            $query->whereGuardName($this->guardName);
        }
        $this->selectOptionsData = $query->get();

        return $this->selectOptionsData;
    }

}
