<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Houseboat;
use App\Repositories\Ext\SelectOptions;

class HouseboatModelRepository extends Repository
{
    use SelectOptions;

    protected static $model = Houseboat::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_HOUSEBOAT_MODEL;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_HOUSEBOAT_MODEL;
}
