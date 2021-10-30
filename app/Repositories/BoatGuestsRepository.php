<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\BoatGuest;
use App\Repositories\Ext\SelectOptions;

class BoatGuestsRepository extends Repository
{
    use SelectOptions;

    protected static $model = BoatGuest::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_BOAT_GUEST;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_BOAT_GUEST;
}
