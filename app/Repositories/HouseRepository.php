<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\House;
use App\Repositories\Ext\SelectOptions;

class HouseRepository extends Repository
{
    use SelectOptions;

    protected static $model = House::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_HOUSE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_HOUSE;
}
