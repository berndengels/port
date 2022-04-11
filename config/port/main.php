<?php
use Carbon\Carbon;

return [
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
    'default'   => [
        'country_id'    => env('DEFAULT_COUNTRY_ID', 55),
        'pagination'    => [
            'limit' => env('PAGINATIN_LIMIT', 10)
        ],
    ],
    'customer'  => [
        'types'         => [
            'guest' => 'guest',
            'permanent' => 'permanent',
            'houseboat'  => 'houseboat',
            'tinyhouse'  => 'tinyhouse',
        ],
        'typeOptions'   => [
            'guest' => 'Gast',
            'permanent' => 'Dauerlieger',
            'houseboat'  => 'Hausboot',
            'tinyhouse'  => 'TinyHouse',
        ],
    ],
    'boat'  => [
        'enabled'   => env('BOAT_ENABLED', true),
        'types' => ['motor' => 'Motorboot', 'sail' => 'Segelboot'],
        'dates' => ['modi' => json_decode(env('BOAT_DATES_MODI'), true)],
        'material' => [
            'modi'  => [
                'underwater'  => 'Unterwasser',
                'board'  => 'Bordwand',
                'deck'  => 'Deck',
                'all'  => 'Irrelevant',
            ],
        ],
    ],
    'guestBoat' => [
        'enabled'   => env('GUEST_BOAT_ENABLED', true),
    ],
    'caravan' => [
        'enabled'   => env('CARAVAN_ENABLED', true),
    ],
    'cache' => [
        'enabled' => env('USE_CACHE', false),
    ],
    'show' => [
        'env'   => env('SHOW_ENV', false),
    ],
];
