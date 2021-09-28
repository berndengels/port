<?php
namespace App\Libs;

use Carbon\Carbon;

class CaravanPriceCalculator extends PriceCalculator
{
    public static function getPrice(Carbon $from, Carbon $until, int $length, int $persons = 1, bool $electric = false, int $dayPrice = null) {
        $countDays = $from->diffInDays($until);

        $total = 0;
        $configSaisonFromMonth      = config('port.dates.saison.fromMonth');
        $configSaisonUntilMonth     = config('port.dates.saison.untilMonth');

        $configPersonsInclusive     = config('port.prices.caravan.persons_inclusivce');
        $configPersonsAdditional    = config('port.prices.caravan.persons_additionaL');

        $configElectricPrice        = config('port.prices.caravan.electric_per_day');
        $configDefaultPricePerDay   = config('port.prices.caravan.default_per_day');
        $configLengthDefaultRange   = array_keys($configDefaultPricePerDay);
        $configSaisonPricePerDay    = config('port.prices.caravan.saison_per_day');
        $configLengthSaisonRange    = array_keys($configSaisonPricePerDay);

        $configDefaultMinPricePerDay = $dayPrice ?? config('port.prices.caravan.min_price_default');
        $configDefaultMaxPricePerDay = $dayPrice ?? config('port.prices.caravan.max_price_default');
        $configSaisontMinPricePerDay = $dayPrice ?? config('port.prices.caravan.min_price_saison');
        $configSaisonMaxPricePerDay  = $dayPrice ?? config('port.prices.caravan.max_price_saison');

        $days       = [];
        $current    = $from->copy();
        $i = 0;

        while ($i < $countDays) {
            if(0 === $i) {
                $day = $current;
            } else {
                $day = $current->addDay();
            }
            $sumPersonsPrice = 0;
            // add price per person exclusive
            if($persons > $configPersonsInclusive) {
                $addPersons = $persons - $configPersonsInclusive;
                $sumPersonsPrice = $configPersonsAdditional * $addPersons;
            }
            $price = $sumPersonsPrice;
            // add electric price
            if($electric) {
                $price += $configElectricPrice;
            }
            // saison
            if($day->month >= $configSaisonFromMonth && $day->month <= $configSaisonUntilMonth) {
                if(min($configLengthSaisonRange) > $length) {
                    $carPricePerDay = $configSaisontMinPricePerDay;
                } else if(max($configLengthSaisonRange) < $length) {
                    $carPricePerDay = $configSaisonMaxPricePerDay;
                } else {
                    $carPricePerDay = isset($configSaisonPricePerDay[$length]) ? $configSaisonPricePerDay[$length] : 0;
                }
            }
            // neben saison
            else
            {
                if(min($configLengthDefaultRange) > $length) {
                    $carPricePerDay = $configDefaultMinPricePerDay;
                } else if(max($configLengthDefaultRange) < $length) {
                    $carPricePerDay = $configDefaultMaxPricePerDay;
                } else {
                    $carPricePerDay = isset($configDefaultPricePerDay[$length]) ? $configDefaultPricePerDay[$length] : 0;
                }
            }
            $price += $dayPrice ?? $carPricePerDay;

            $total += $price;
            $days[$day->format('Y-m-d')] = [
                'date'              => $day->format('d.m.Y'),
                'persons'           => $persons,
                'sum_person_price'  => $sumPersonsPrice,
                'electric_per_day'  => $electric ? $configElectricPrice : 0,
                'is_saison'         => (int) ($day->month >= $configSaisonFromMonth && $day->month <= $configSaisonUntilMonth),
                'car_length'        => $length,
                'car_price_per_day' => $dayPrice ?? $carPricePerDay,
                'sum_price'         => $price,
            ];

            $i++;
        }
        return ['total' => $total, 'prices' => $days];
    }
}
