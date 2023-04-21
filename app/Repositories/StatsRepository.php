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

    public static function getSalesVolume() {
        if(static::$model) {
            return self::getSalesVolumByMonth(modelClass:  static::$model);
        }
    }

    public static function getRentalSalesVolume() {
        if(static::$model) {
            return self::getRentalSalesVolumByMonth(modelClass:  static::$model);
        }
    }
}
