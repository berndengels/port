<?php
namespace App\Repositories\Ext;

use Illuminate\Support\Facades\Cache;

trait SelectOptions
{
    public static function optionsData($orderBy = 'name')
    {
        $cacheKey = static::$model.'OptionsData';
        if(! Cache::has($cacheKey)) {
            $options = (static::$model)::select()
                ->orderBy($orderBy)
                ->get()
            ;
            Cache::put($cacheKey, $options);
        } else {
            $options = Cache::get($cacheKey);
        }
        return $options;
    }

    public static function options($textFieldName = 'name', $keyFieldName = 'id')
    {
        $cacheKey = static::$model.'SelectOptions';
        if(! Cache::has($cacheKey)) {
            $options = self::optionsData($textFieldName)
                ->keyBy($keyFieldName)
                ->map->{$textFieldName}
            ;
            Cache::put($cacheKey, $options);
        } else {
            $options = Cache::get($cacheKey);
        }
        return $options;
    }
}
