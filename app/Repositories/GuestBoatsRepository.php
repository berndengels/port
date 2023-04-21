<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\GuestBoat;
use App\Repositories\Ext\SelectOptions;

class GuestBoatsRepository extends Repository
{
    use SelectOptions;

    protected static $model = GuestBoat::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_GUEST_BOAT;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_GUEST_BOAT;
}
