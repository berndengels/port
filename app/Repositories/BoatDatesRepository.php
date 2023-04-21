<?php

namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\BoatDates;

class BoatDatesRepository extends StatsRepository
{
    protected static $model = BoatDates::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_BOAT_DATES;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_BOAT_DATES;
}
