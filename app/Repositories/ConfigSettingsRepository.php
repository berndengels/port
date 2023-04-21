<?php
namespace App\Repositories;

use App\Libs\AppCache;
use App\Models\ConfigSetting;

class ConfigSettingsRepository extends Repository
{
    protected static $model = ConfigSetting::class;
    protected static $cacheKey = AppCache::KEY_CONFIG_SETTINGS;
    protected static $ttl = 7200;
}
