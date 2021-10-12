<?php

use Carbon\Carbon;

return [
    'caravan' => [
        'electric_per_day'      => env('CARAVAN_PRICE_ELECTRIC_PER_DAY', 2),
        'persons_inclusivce'    => env('CARAVAN_PRICE_PERSONS_INCLUSIVE', 2),
        'persons_additional'    => env('CARAVAN_PRICE_ADDITIONAL_PERSONS_PER_DAY', 1),
        'default_per_day'       => json_decode(env('CARAVAN_PRICE_DEFAULT', '{error: "no data"}'), true),
        'saison_per_day'        => json_decode(env('CARAVAN_PRICE_SAISON', '{error: "no data"}'), true),
        'min_price_default'     => env('CARAVAN_MIN_PRICE_DEAULT', 7),
        'max_price_default'     => env('CARAVAN_MAX_PRICE_DEAULT', 12),
        'min_price_saison'      => env('CARAVAN_MIN_PRICE_SAISON', 10),
        'max_price_saison'      => env('CARAVAN_MAX_PRICE_SAISON', 15),
    ],
    'boat' => [
        'price_saison_factor'  => env('BOAT_PRICE_SAISON_FACTOR'),
        'price_winter_factor'  => env('BOAT_PRICE_WINTER_FACTOR'),
        'saison_start'  => env('BOAT_SAISON_START'),
        'saison_end'    => env('BOAT_SAISON_END'),
        'winter_start'  => env('BOAT_WINTER_START'),
        'winter_end'    => env('BOAT_WINTER_END'),
        'crane_per_ton' => env('BOAT_CRANE_PRICE_PER_TON'),
        'mast_crane'    => env('BOAT_CRANE_MAST_PRICE'),
        'high_pressure_cleaning'  => env('BOAT_HIGH_PRESSURE_CLEANING_PRICE'),
    ],
    'boat_guest' => [
        'price_per_meter'      => env('BOAT_GUEST_PRICE_PER_METER', 1.5),
    ],
];
