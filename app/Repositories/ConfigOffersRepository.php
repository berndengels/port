<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ConfigOffer;
use App\Repositories\Ext\SelectOptions;

class ConfigOffersRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigOffer::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CONFIG_OFFER_TYPE;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CONFIG_OFFER_TYPE;

}
