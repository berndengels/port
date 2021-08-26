<?php
namespace App\Libs;

use Carbon\Carbon;

class CaravanPriceCalculator extends PriceCalculator
{
    public function getPrice(Carbon $from, Carbon $until, $length, int $person = 1, bool $electric = false) {
//        $days = $from->diffInDays($until);

//        $price                  = 0;
        $days[]                 = $from->copy();
        $current                = $from;
        $configSaisonFromMonth  = config('port.dates.saison.fromMonth');
        $configSaisonUntilMonth = config('port.dates.saison.untilMonth');

        $configPersonsPrice     = config('port.prices.caravan.per_persons');
        $configElectricPrice    = config('port.prices.caravan.electric_per_day');
        $configShortLength      = config('port.prices.caravan.shortLength');
        if($length <= $configShortLength) {
            $configLength = config('port.prices.caravan.length.short');
        } else {
            $configLength = config('port.prices.caravan.length.long');
        }

        while ($current->lte($until)) {
            $price = $configPersonsPrice;
            if($electric) {
                $price += $configElectricPrice;
            }
            $month = $from->month;
            if($month >= $configSaisonFromMonth && $month <= $configSaisonUntilMonth) {
                $price += $configLength->saison->per_day;
            } else {
                $price += $configLength->default->per_day;
            }
            $day = $current->addDay();
            $days[$day->format('y-m-d')] = [
                'day' => $day,
                'price' => $price

            ];
        }
        return config('port');
    }
}
