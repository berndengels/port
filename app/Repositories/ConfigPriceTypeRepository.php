<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ConfigPriceType;
use App\Repositories\Ext\SelectOptions;

class ConfigPriceTypeRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigPriceType::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_PRICE_TYPE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_PRICE_TYPE;

}
