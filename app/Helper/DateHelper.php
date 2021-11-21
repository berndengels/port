<?php

namespace App\Helper;

use Carbon\Carbon;

class DateHelper
{
    public static function randomDate(string $minStartDate, string $maxEndDate, $format = 'Y-m-d') {
        $startDate  = Carbon::create($minStartDate);
        $endDate    = Carbon::create($maxEndDate);
        $diff       = $startDate->diffInDays($endDate);

        return $startDate->copy()->addDays(rand(1, $diff))->format($format);
    }
}
