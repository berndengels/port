<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\PriceType;
use App\Repositories\Ext\SelectOptions;

class PriceTypeRepository extends Repository
{
    use SelectOptions;

    protected static $model = PriceType::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_PRICE_TYPE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_PRICE_TYPE;

}
