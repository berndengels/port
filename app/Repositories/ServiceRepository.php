<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Service;
use App\Repositories\Ext\SelectOptions;

class ServiceRepository extends Repository
{
    use SelectOptions;

    protected static $model = Service::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_SERVICE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_SERVICE;

}
