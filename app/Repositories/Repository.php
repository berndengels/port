<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class Repository
{
    protected static $ttl;
    protected static $model;
    protected static $cacheKey;
    protected static $cacheKeyOptions;
    protected static $cacheKeyOptionsData;

    public static function getAll()
    {
        return Cache::remember(static::$cacheKey.'.all', static::$ttl, fn() => (static::$model)::all());
    }

    public static function getOne(int $id)
    {
        return Cache::remember(static::$cacheKey.'.one', static::$ttl, fn() => (static::$model)::find($id));
    }

    public static function getFirst()
    {
        return Cache::remember(static::$cacheKey.'.first', static::$ttl, fn() => (static::$model)::first());
    }
}
