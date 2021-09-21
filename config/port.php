<?php
use Carbon\Carbon;

return [
    'menu'  => [
        'admin' => [
            'items' => [
                'Dashboard'   => [
                    'text'  => 'Dashboard',
                    'title' => 'Dashboard',
                    'icon'  => 'fas fa-caravan',
                    'route' => 'dashboard',
                ],
                'Caravans'   => [
                    [
                        'text'  => 'Caravans',
                        'title' => 'Caravans',
                        'icon'  => 'fas fa-caravan',
                        'route' => 'caravans.index',
                    ],
                    [
                        'text'  => 'Caravan Rezeption',
                        'title' => 'Caravan Rezeption',
                        'icon'  => 'fas fa-concierge-bell',
                        'route' => 'caravanDates.index',
                    ],
                ],
                'Boote'   => [
                    [
                        'text'  => 'Dauerlieger',
                        'title' => 'Dauerlieger',
                        'icon'  => 'fas fa-caravan',
                        'route' => 'caravans.index',
                    ],
                    [
                        'text'  => 'Gäste',
                        'title' => 'Gäste',
                        'icon'  => 'fas fa-concierge-bell',
                        'route' => 'caravanDates.index',
                    ],
                ],
            ],
        ],
    ],
    'mail' => [
        'sender'  => [
            'address'   => env('MAIL_FROM_ADDRESS', null),
            'name'      => env('MAIL_FROM_NAME', null),
        ],
    ],
    'dates' => [
        'saison' => [
            'fromMonth'     => env('MONTH_SAISON_START', Carbon::JUNE),
            'untilMonth'    => env('MONTH_SAISON_END', Carbon::SEPTEMBER),
        ],
    ],
    'prices'    => [
        'caravan' => [
            'electric_per_day'      => env('CARAVAN_PRICE_ELECTRIC_PER_DAY', 2),
            'persons_inclusivce'    => env('CARAVAN_PRICE_PERSONS_INCLUSIVE', 2),
            'persons_additionaL'    => env('CARAVAN_PRICE_ADDITIONAL_PERSONS_PER_DAY', 1),
            'default_per_day'       => json_decode(env('CARAVAN_PRICE_DEFAULT', '{error: "no data"}'), true),
            'saison_per_day'        => json_decode(env('CARAVAN_PRICE_SAISON', '{error: "no data"}'), true),
            'min_price_default'     => env('CARAVAN_MIN_PRICE_DEAULT', 7),
            'max_price_default'     => env('CARAVAN_MAX_PRICE_DEAULT', 12),
            'min_price_saison'      => env('CARAVAN_MIN_PRICE_SAISON', 10),
            'max_price_saison'      => env('CARAVAN_MAX_PRICE_SAISON', 15),
        ],
    ],
];
