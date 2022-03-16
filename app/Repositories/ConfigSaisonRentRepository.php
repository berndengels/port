<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ConfigSaisonRent;
use App\Repositories\Ext\SelectOptions;

class ConfigSaisonRentRepository extends Repository
{
    use SelectOptions;

    protected static $model = ConfigSaisonRent::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_CONFIG_SAISON_RENT;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_CONFIG_SAISON_RENT;
}
