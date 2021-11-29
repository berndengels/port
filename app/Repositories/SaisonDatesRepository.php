<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\SaisonDates;
use App\Repositories\Ext\SelectOptions;

class SaisonDatesRepository extends Repository
{
    use SelectOptions;

    protected static $model = SaisonDates::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_SAISON_DATES;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_SAISON_DATES;
}
