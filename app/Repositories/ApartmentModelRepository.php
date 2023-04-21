<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ApartmentModel;
use App\Repositories\Ext\SelectOptions;

class ApartmentModelRepository extends Repository
{
    use SelectOptions;

    protected static $model = ApartmentModel::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_APARTMENT_MODEL;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_APARTMENT_MODEL;
}
