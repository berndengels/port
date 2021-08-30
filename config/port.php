<?php
use Carbon\Carbon;

return [
    'dates' => [
        'saison' => [
            'fromMonth'  => env('MONTH_SAISON_START', Carbon::JUNE),
            'untilMonth'  => env('MONTH_SAISON_END', Carbon::SEPTEMBER),
        ],
    ],
    'prices'    => [
        'caravan' => [
            'electric_per_day'  => env('CARAVAN_PRICE_ELECTRIC_PER_DAY', 2),
            'persons_per_day' => env('CARAVAN_PRICE_PERSONS_PER_DAY', 1),
            'default_per_day'   => json_decode(env('CARAVAN_PRICE_DEFAULT', '{error: "no data"}'), true),
            'saison_per_day'    => json_decode(env('CARAVAN_PRICE_SAISON', '{error: "no data"}'), true),
            'min_price_default' => env('', 7),
            'max_price_default' => env('', 12),
            'min_price_saison' => env('', 10),
            'max_price_saison' => env('', 15),
        ],
    ],
];
