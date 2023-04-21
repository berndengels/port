<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\MaterialCategory;
use App\Repositories\Ext\SelectOptions;

class MaterialCategoryRepository extends Repository
{
    use SelectOptions;

    protected static $model = MaterialCategory::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_MATERIAL_CATEGORY;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_MATERIAL_CATEGORY;

}
