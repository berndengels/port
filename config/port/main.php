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
        'types' => env('CUSTOMER_TYPES', ['guest' => 'guest', 'permanent' => 'permanent'])
    ],
    'boat'  => [
        'types' => env('BOAT_TYPES', ['motor' => 'motor', 'sail' => 'sail']),
        'dates' => ['modi' => json_decode(env('BOAT_DATES_MODI'), true)],
    ],
];
