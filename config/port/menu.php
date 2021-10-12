<?php
return [
    'public' => [
        'items' => [
            'Dashboard'   => [
                'text'  => 'Dashboard',
                'title' => 'Dashboard',
                'icon'  => 'fas fa-home',
                'route' => 'public.dashboard',
            ],
        ],
    ],
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
            'Content'   => [
                'permissions'   => ['read ContentMenu'],
                'icon'  => 'fas fa-newspaper',
                'items' => [
                    [
                        'permissions'   => ['read Page', 'write Page'],
                        'text'  => 'Pages',
                        'title' => 'Pages',
                        'icon'  => 'fas fa-file',
                        'route' => 'admin.pages.index',
                    ],
                    [
                        'permissions'   => ['read Widget', 'write Widget'],
                        'text'  => 'Widgets',
                        'title' => 'Widgets',
                        'icon'  => 'fas fa-newspaper',
                        'route' => 'admin.widgets.index',
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
            'Kunden'   => [
                'permissions'   => ['read CustomersMenu'],
                'icon'  => 'fas fa-user',
                'items' => [
                    [
                        'permissions'   => ['read Customer', 'write Customer'],
                        'text'  => 'Dauerlieger',
                        'title' => 'Dauerlieger',
                        'icon'  => 'fas fa-user',
                        'route' => 'admin.customers.index',
                    ],
                    [
                        'permissions'   => ['read Customer', 'write Customer'],
                        'text'  => 'Gäste',
                        'title' => 'Gäste',
                        'icon'  => 'fas fa-concierge-bell',
                        'route' => 'admin.customers.guests',
                    ],
                ],
            ],
            'Boote'   => [
                'permissions'   => ['read BoatsMenu'],
                'icon'  => 'fas fa-ship',
                'items' => [
                    [
                        'permissions'   => ['read Boat','write Boat'],
                        'text'  => 'Gäste',
                        'title' => 'Gäste',
                        'icon'  => 'fas fa-concierge-bell',
                        'route' => 'admin.boats.guests',
                    ],
/*
                    [
                        'permissions'   => ['read Boat','write Boat'],
                        'text'  => 'Gäste Rezeption',
                        'title' => 'Gäste Rezeption',
                        'icon'  => 'fas fa-concierge-bell',
                        'route' => 'admin.boats.guests',
                    ],
*/
                    [
                        'permissions'   => ['read Boat','write Boat'],
                        'text'  => 'Dauerlieger',
                        'title' => 'Dauerlieger',
                        'icon'  => 'fas fa-ship',
                        'route' => 'admin.boats.index',
                    ],
                    [
                        'permissions'   => ['read BoatDates','write BoatDates'],
                        'text'  => 'Saison Liegeplätze',
                        'title' => 'Saison Liegeplätze',
                        'icon'  => 'fas fa-anchor',
                        'route' => 'admin.boatDates.saison',
                    ],
                    [
                        'permissions'   => ['read BoatDates','write BoatDates'],
                        'text'  => 'Winterlager',
                        'title' => 'Winterlager',
                        'icon'  => 'fas fa-snowflake',
                        'route' => 'admin.boatDates.winter',
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
        ],
    ],
];
