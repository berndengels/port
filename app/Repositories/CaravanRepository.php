<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Caravan;
use App\Repositories\Ext\SelectOptions;

class CaravanRepository extends Repository
{
    use SelectOptions;

    protected static $model = Caravan::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CARAVAN;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CARAVAN;
}
