<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ConfigPriceComponent;
use App\Repositories\Ext\SelectOptions;

class ConfigPriceComponentRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigPriceComponent::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CONFIG_PRICE_COMPONENT;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CONFIG_PRICE_COMPONENT;

}
