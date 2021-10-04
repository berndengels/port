<?php
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
];
