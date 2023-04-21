<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Apartment;
use App\Repositories\Ext\SelectOptions;

class ApartmentRepository extends Repository
{
    use SelectOptions;

    protected static $model = Apartment::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_APARTMENT;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_APARTMENT;
}
