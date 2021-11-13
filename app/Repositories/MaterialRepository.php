<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\Material;
use App\Repositories\Ext\SelectOptions;

class MaterialRepository extends Repository
{
    use SelectOptions;

    protected static $model = Material::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_MATERIAL;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_MATERIAL;

}
