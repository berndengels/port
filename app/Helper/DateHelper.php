<?php

namespace App\Helper;

class DateHelper
{
    /**
     * Method to generate random date between two dates
     * @param $sStartDate
     * @param $sEndDate
     * @param string $sFormat
     * @return bool|string
     */
    public static function randomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d H:i:s') {
        // Convert the supplied date to timestamp
        $fMin = strtotime($sStartDate);
        $fMax = strtotime($sEndDate);

        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);

        // Convert back to the specified date format
        return date($sFormat, $fVal);
    }

}
