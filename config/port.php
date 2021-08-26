<?php
use Carbon\Carbon;

return [
    'dates' => [
        'saison' => [
            'fromMonth'  => Carbon::JUNE,
            'untilMonth'  => Carbon::SEPTEMBER,
        ],
    ],
    'prices'    => [
        'caravan' => [
            'electric_per_day'  => 2,
            'shortLength' => 9,
            'longLength' => 10,
            'length'    => [
                'short' => [
                    'default'   => [
                        'per_day'   => 9,
                    ],
                    'saison' => [
                        'per_day'   => 10,
                    ],
                ],
                'long' => [
                    'default'   => [
                        'per_day'   => 12,
                    ],
                    'saison' => [
                        'per_day'   => 15,
                    ],
                ],
            ],
            'per_persons' => 1,
        ],
        'guestBoat' => [
            'electric_per_day'  => 2,
        ],
        'boat' => [
        ],
    ],
];
