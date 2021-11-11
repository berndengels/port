<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ServiceCategory;
use App\Repositories\Ext\SelectOptions;

class ServiceCategoryRepository extends Repository
{
    use SelectOptions;

    protected static $model = ServiceCategory::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_SERVICE_CATEGORY;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_SERVICE_CATEGORY;

}
