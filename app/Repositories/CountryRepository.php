<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Country;
use App\Repositories\Ext\SelectOptions;

class CountryRepository extends Repository
{
    use SelectOptions;

    protected static $model = Country::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_COUNTRY;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_COUNTRY;

}
