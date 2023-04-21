<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Rentable;
use App\Repositories\Ext\SelectOptions;

class RentableRepository extends StatsRepository
{
    protected static $model = Rentable::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_RENTABLE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_RENTABLE;
}
