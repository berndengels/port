<?php

return [
/*
    'tax'   => [
        'enabled'   => (bool) env('PORT_TAX_ENABLED', false),
        'rate'   => (float) env('PORT_TAX_RATE', 19),
    ],
    'caravan' => [
        'electric_per_day'      => (float) env('CARAVAN_PRICE_ELECTRIC_PER_DAY', 2),
        'persons_inclusivce'    => (float) env('CARAVAN_PRICE_PERSONS_INCLUSIVE', 2),
        'persons_additional'    => (float) env('CARAVAN_PRICE_ADDITIONAL_PERSONS_PER_DAY', 1),
        'default_per_day'       => json_decode(env('CARAVAN_PRICE_DEFAULT', '{error: "no data"}'), true),
        'saison_per_day'        => json_decode(env('CARAVAN_PRICE_SAISON', '{error: "no data"}'), true),
        'min_price_default'     => (float) env('CARAVAN_MIN_PRICE_DEAULT', 7),
        'max_price_default'     => (float) env('CARAVAN_MAX_PRICE_DEAULT', 12),
        'min_price_saison'      => (float) env('CARAVAN_MIN_PRICE_SAISON', 10),
        'max_price_saison'      => (float) env('CARAVAN_MAX_PRICE_SAISON', 15),
    ],
    'boat' => [
        'price_saison_factor'  => (float) env('BOAT_PRICE_SAISON_FACTOR'),
        'price_winter_factor'  => (float) env('BOAT_PRICE_WINTER_FACTOR'),
        'saison_start'  => env('BOAT_SAISON_START'),
        'saison_end'    => env('BOAT_SAISON_END'),
        'winter_start'  => env('BOAT_WINTER_START'),
        'winter_end'    => env('BOAT_WINTER_END'),
        'crane_per_ton' => (float) env('BOAT_CRANE_PRICE_PER_TON'),
        'mast_crane'    => (float) env('BOAT_CRANE_MAST_PRICE'),
        'mast_crane_upper_per_100kg'    => (float) env('BOAT_CRANE_MAST_PRICE_UPPER_PER_100KG'),
        'cleaning_per_length'           => (float) env('BOAT_CLEANING_PRICE_PER_LENGTH_METER'),
    ],
    'boat_guest' => [
        'price_per_meter'       => (float) env('BOAT_GUEST_PRICE_PER_METER', 1.5),
        'electric_per_day'      => (float) env('BOAT_GUEST_PRICE_ELECTRIC_PER_DAY', 2),
        'persons_inclusivce'    => (float) env('BOAT_GUEST_PRICE_PERSONS_INCLUSIVE', 2),
        'persons_additional'    => (float) env('BOAT_GUEST_PRICE_ADDITIONAL_PERSONS_PER_DAY', 1),
    ],
*/
    'fertility' => [
        'types' =>
            [
                'meter' => 'per Meter',
                'quadratmeter' => 'per Quadratmeter',
            ],
        'units' => [
            'Meter' => 'Meter',
            'Quadratmeter' => 'Quadratmeter',
            'Liter' => 'Liter',
        ],
        'per' => [
            'Meter' => 'Meter',
            'Quadratmeter' => 'Quadratmeter',
            'Liter' => 'Liter',
        ],
    ],

];
