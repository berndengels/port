<?php
use Carbon\Carbon;

return [
    'menu'  => [
        'admin' => [
            'items' => [
                'Dashboard'   => [
                    'text'  => 'Dashboard',
                    'title' => 'Dashboard',
                    'icon'  => 'fas fa-home',
                    'route' => 'admin.dashboard',
                ],
                'Caravans'   => [
                    'permissions'   => ['read CaravansMenu'],
                    'icon'  => 'fas fa-caravan',
                    'items' => [
                        [
                            'permissions'   => ['read Caravan', 'write Caravan'],
                            'text'  => 'Caravans',
                            'title' => 'Caravans',
                            'icon'  => 'fas fa-caravan',
                            'route' => 'admin.caravans.index',
                        ],
                        [
                            'permissions'   => ['read CaravanDates', 'write CaravanDates'],
                            'text'  => 'Caravan Rezeption',
                            'title' => 'Caravan Rezeption',
                            'icon'  => 'fas fa-concierge-bell',
                            'route' => 'admin.caravanDates.index',
                        ],
                    ],
                ],
                'Permissions'   => [
                    'permissions'   => ['read PermissionsMenu'],
                    'icon'  => 'fas fa-user-lock',
                    'items' => [
                        [
                            'permissions'   => ['read User', 'write User'],
                            'text'  => 'Users',
                            'title' => 'Users',
                            'icon'  => 'fas fa-user',
                            'route' => 'admin.users.index',
                        ],
                        [
                            'permissions'   => ['read Role', 'write Role'],
                            'text'  => 'Roles',
                            'title' => 'Roles',
                            'icon'  => 'fas fa-user-tag',
                            'route' => 'admin.roles.index',
                        ],
                        [
                            'permissions'   => ['read Permission', 'write Permission'],
                            'text'  => 'Permissions',
                            'title' => 'Permissions',
                            'icon'  => 'fas fa-user-tag',
                            'route' => 'admin.permissions.index',
                        ],
                    ],
                ],
                'Info'   => [
                    'permissions'   => ['read InfoMenu'],
                    'icon'  => 'fas fa-info-circle',
                    'items' => [
                        [
                            'permissions'   => ['read Routes'],
                            'text'  => 'Routes',
                            'title' => 'Routes',
                            'icon'  => 'fas fa-route',
                            'route' => 'admin.routes.index',
                        ],
                    ],
                ],
/*
                'Boote'   => [
                    'icon'  => 'fas fa-ship',
                    'items' => [
                        [
                            'text'  => 'Dauerlieger',
                            'title' => 'Dauerlieger',
                            'icon'  => 'fas fa-caravan',
                            'route' => 'admin.caravans.index',
                        ],
                        [
                            'text'  => 'Gäste',
                            'title' => 'Gäste',
                            'icon'  => 'fas fa-concierge-bell',
                            'route' => 'admin.caravanDates.index',
                        ],
                    ],
                ],
*/
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
    'map'   => [
        'lat'   => 54.026379,
        'lng'   => 13.910093,
        'zoom'  => 12,
        'token' => env('MIX_NAVIONICS_TOKEN'),
    ],
    'default'   => [
        'country_id'    => env('DEFAULT_COUNTRY_ID', 55),
        'pagination'    => [
            'limit' => env('PAGINATIN_LIMIT', 10)
        ],
    ],
];
