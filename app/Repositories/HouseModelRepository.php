<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\HouseModel;
use App\Repositories\Ext\SelectOptions;

class HouseModelRepository extends Repository
{
    use SelectOptions;

    protected static $model = HouseModel::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_HOUSE_MODEL;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_HOUSE_MODEL;
}
