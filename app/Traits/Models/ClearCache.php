<?php

namespace App\Traits\Models;

trait ClearCache
{
    public static function bootClearCache()
    {
/*
        self::created(function () {
            ResponseCache::clear();
        });

        self::updated(function () {
            ResponseCache::clear();
        });

        self::deleted(function () {
            ResponseCache::clear();
        });
*/
    }
}
