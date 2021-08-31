<?php
namespace App\Libs;

use Carbon\Carbon;

class CaravanPriceCalculator extends PriceCalculator
{
    public static function getPrice(Carbon $from, Carbon $until, int $length, int $persons = 1, bool $electric = false) {
        $countDays = $from->diffInDays($until);

        $total = 0;
        $configSaisonFromMonth      = config('port.dates.saison.fromMonth');
        $configSaisonUntilMonth     = config('port.dates.saison.untilMonth');
        $configPersonsPrice         = config('port.prices.caravan.persons_per_day');
        $configElectricPrice        = config('port.prices.caravan.electric_per_day');
        $configDefaultPricePerDay   = config('port.prices.caravan.default_per_day');
        $configLengthDefaultRange   = array_keys($configDefaultPricePerDay);
        $configSaisonPricePerDay    = config('port.prices.caravan.saison_per_day');
        $configLengthSaisonRange    = array_keys($configSaisonPricePerDay);

        $configDefaultMinPricePerDay = config('port.prices.caravan.min_price_default');
        $configDefaultMaxPricePerDay = config('port.prices.caravan.max_price_default');
        $configSaisontMinPricePerDay = config('port.prices.caravan.min_price_saison');
        $configSaisonMaxPricePerDay  = config('port.prices.caravan.max_price_saison');

        $days       = [];
        $current    = $from->copy();
        $i = 0;
        $arrPrices = [];
        while ($i < $countDays) {
            if(0 === $i) {
                $day = $current;
            } else {
                $day = $current->addDay();
            }

            $sumPersonsPrice = $configPersonsPrice * $persons;
            $price = $configPersonsPrice * $persons;
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
            // nach oder vor saison
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
            $price += $carPricePerDay;

            $total += $price;
            $days[$day->format('Y-m-d')] = [
                'date'              => $day->format('d.m.Y'),
                'persons'           => $persons,
                'price_per_person'  => $configPersonsPrice,
                'sum_person_price'  => $sumPersonsPrice,
                'electric_per_day'  => $electric ? $configElectricPrice : 0,
                'is_saison'         => (int) ($day->month >= $configSaisonFromMonth && $day->month <= $configSaisonUntilMonth),
                'car_length'        => $length,
                'car_price_per_day' => $carPricePerDay,
                'sum_price'         => $price,
            ];

            $i++;
        }

        return ['total' => $total, 'prices' => $days];
    }
}
