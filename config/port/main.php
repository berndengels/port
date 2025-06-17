<?php

return [
	'master' => [
		'email'	=> env('MASTER_EMAIL', null),
	],
    'default'   => [
        'country_id'    => env('DEFAULT_COUNTRY_ID', 55),
        'pagination'    => [
            'limit' => env('PAGINATIN_LIMIT', 50)
        ],
    ],
    'customer'  => [
        'types'         => [
            'guest'     => 'guest',
            'permanent' => 'permanent',
            'renter'    => 'renter',
/*
            'houseboat' => 'houseboat',
            'house'     => 'house',
            'apartment' => 'apartment',
*/
        ],
		'typeModels'         => [
			'guest'     => 'guest',
			'permanent' => 'permanent',
		],
        'typeOptions'   => [
            'guest'     => 'Gastboot',
            'permanent' => 'Dauerlieger Boot',
            'renter'    => 'Mieter',
/*
            'houseboat' => 'Hausboot Mieter ',
            'house'     => 'Haus Mieter',
            'apartment' => 'Apartment Mieter',
*/
        ],
    ],
    'boat'  => [
        'types' => ['motor' => 'Motorboot', 'sail' => 'Segelboot'],
        'dates' => ['modi' => [
                ''  => 'Art wählen',
                'summer'  => 'Sommerliegeplatz',
                'winter'  => 'Winterlager',
            ]
        ],
        'material' => [
            'modi'  => [
                'underwater'  => 'Unterwasser',
                'board'  => 'Bordwand',
                'deck'  => 'Deck',
                'all'  => 'Irrelevant',
            ],
        ],
    ],
	'webhook'	=> [
		'header'	=> env('EP_WEBHOOK_HEADER_NAME'),
		'secret'	=> env('EP_WEBHOOK_CLIENT_SECRET'),
	],
];
