<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ConfigService;
use App\Repositories\Ext\SelectOptions;

class ConfigServiceRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigService::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CONFIG_SERVICE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CONFIG_SERVICE;

}
