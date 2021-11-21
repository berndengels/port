<?php

namespace App\Repositories;

use App\Repositories\Ext\Stats;

class StatsRepository
{
    use Stats;
    protected static $model;

    public static function getVisits() {
        if(static::$model) {
            return self::getVisitsByDate(static::$model);
        }
    }
}
