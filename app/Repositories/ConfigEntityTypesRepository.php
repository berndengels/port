<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ConfigEntityType;
use App\Models\ConfigService;
use App\Repositories\Ext\SelectOptions;

class ConfigEntityTypesRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigEntityType::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CONFIG_ENTITY_TYPE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CONFIG_ENTITY_TYPE;

}
