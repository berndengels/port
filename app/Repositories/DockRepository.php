<?php
namespace App\Repositories;

use App\Models\Dock;
use App\Libs\AppCache;
use App\Repositories\Ext\SelectOptions;

class DockRepository extends Repository
{
    use SelectOptions;

    protected static $model = Dock::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_DOCK;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_DOCK;
}
