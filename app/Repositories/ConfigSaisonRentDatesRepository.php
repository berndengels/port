<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ConfigHoliday;
use App\Models\ConfigSaisonRent;
use App\Models\ConfigSaisonRentDates;
use App\Repositories\Ext\SelectOptions;
use Carbon\Carbon;

class ConfigSaisonRentDatesRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigSaisonRentDates::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CONFIG_SAISON_RENT_DATES;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CONFIG_SAISON_RENT_DATES;
}
