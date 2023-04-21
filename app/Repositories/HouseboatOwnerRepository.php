<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\HouseboatOwner;
use App\Repositories\Ext\SelectOptions;

class HouseboatOwnerRepository extends Repository
{
    use SelectOptions;

    protected static $model = HouseboatOwner::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_HOUSEBOAT_OWNER;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_HOUSEBOAT_OWNER;

}
