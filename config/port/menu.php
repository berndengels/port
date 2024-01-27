<?php
return [
    'public' => [
        'items' => [
            'Dashboard'   => [
                'text'  => 'Dashboard',
                'title' => 'Dashboard',
                'icon'  => 'fas fa-home',
                'route' => 'public.dashboard',
				'segment' => 'dashboard',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Customer','write Customer'],
                        'text'  => 'Boote',
                        'title' => 'Boote',
                        'icon'  => 'fas fa-ship',
                        'route' => 'customer.profile.index',
						'segment' => 'profile',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Boat','write Boat'],
                        'text'  => 'Caravans',
                        'title' => 'Caravans',
                        'icon'  => 'fas fa-caravan',
                        'route' => 'customer.boats.index',
						'segment' => 'boats',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read BoatDates'],
                        'text'  => 'Hausboote',
                        'title' => 'Hausboote',
                        'icon'  => 'fas fa-house-user',
                        'route' => 'customer.boatDates.index',
						'segment' => 'boatDates',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                ],
            ],
        ],
        'hide_on_mobile' => false,
    ],
    'customer'  => [
        'boat'  => [
            'items' => [
                'Dashboard'   => [
                    'text'  => 'Dashboard',
                    'title' => 'Dashboard',
                    'icon'  => 'fas fa-home',
					'segment' => 'dashboard',
                    'route' => 'public.dashboard',
                    'hide_on_mobile' => false,
                    'help'  => null,
                ],
                'Daten'   => [
                    'permissions'   => ['read ProfileMenu'],
					'text'  => 'Daten',
					'title' => 'Daten',
					'segment' => 'profile',
                    'icon'  => 'fas fa-ship',
                    'hide_on_mobile' => false,
                    'help'  => null,
                    'items' => [
                        [
                            'permissions'   => ['read Customer','write Customer'],
                            'text'  => 'Profile',
                            'title' => 'Profile',
							'segment' => 'profile',
                            'icon'  => null,
                            'route' => 'customer.profile.index',
                            'hide_on_mobile' => false,
                            'help'  => null,
                        ],
                        [
                            'permissions'   => ['read Boat','write Boat'],
                            'text'  => 'Boots Daten',
                            'title' => 'Boots Daten',
							'segment' => 'boats',
                            'icon'  => null,
                            'route' => 'customer.boats.index',
                            'hide_on_mobile' => false,
                            'help'  => null,
                        ],
                        [
                            'permissions'   => ['read BoatDates'],
                            'text'  => 'Rechnungen',
                            'title' => 'Rechnungen',
							'segment' => 'boatDates',
                            'icon'  => null,
                            'route' => 'customer.boatDates.index',
                            'hide_on_mobile' => false,
                            'help'  => null,
                        ],
                    ],
                ],
                'Services' => [
                    'permissions'   => ['read ServiceMenu'],
                    'icon'  => 'fas fa-ship',
					'segment' => 'serviceRequests',
                    'hide_on_mobile' => false,
                    'help'  => null,
                    'items' => [
                        [
                            'permissions'   => ['read ServiceRequest','write ServiceRequest'],
                            'text'  => 'Anfragen',
                            'title' => 'Anfragen',
							'segment' => 'serviceRequests',
                            'icon'  => null,
                            'route' => 'customer.serviceRequests.index',
                            'hide_on_mobile' => false,
                            'help'  => null,
                        ],
						[
							'permissions'   => ['read CraneDate', 'write CraneDate'],
							'text'  => 'Kranen',
							'title' => 'Kranen',
							'segment' => 'craneDates',
							'icon'  => null,
							'route' => 'customer.craneDates.index',
							'hide_on_mobile' => false,
							'help'  => null,
						],
                    ],
                ],
            ],
            'hide_on_mobile' => false,
        ],
        'renter'  => [
            'items' => [
                'Dashboard'   => [
                    'text'  => 'Dashboard',
                    'title' => 'Dashboard',
					'segment' => 'dashboard',
                    'icon'  => 'fas fa-home',
                    'route' => 'public.dashboard',
                    'hide_on_mobile' => false,
                    'help'  => null,
                ],
                'Daten'   => [
                    'permissions'   => ['read ProfileMenu'],
                    'icon'  => 'fas fa-ship',
					'segment' => 'profile',
                    'hide_on_mobile' => false,
                    'help'  => null,
                    'items' => [
                        [
                            'permissions'   => ['read Customer','write Customer'],
                            'text'  => 'Profile',
                            'title' => 'Profile',
							'segment' => 'profile',
                            'icon'  => null,
                            'route' => 'customer.profile.index',
                            'hide_on_mobile' => false,
                            'help'  => null,
                        ],
                    ],
                ],
            ],
            'hide_on_mobile' => false,
        ],
        'hide_on_mobile' => false,
    ],
    'admin' => [
        'items' => [
            'Dashboard'   => [
                'text'  => 'Dashboard',
                'title' => 'Dashboard',
                'icon'  => 'fas fa-home',
                'route' => 'admin.dashboard',
				'segment' => 'dashboard',
                'hide_on_mobile' => false,
                'help'  => null,
            ],
            'Caravans'   => [
                'permissions'   => ['read CaravansMenu'],
                'icon'  => 'fas fa-caravan',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Caravan', 'write Caravan'],
                        'text'  => 'Caravans',
                        'title' => 'Caravans',
                        'icon'  => 'fas fa-caravan',
                        'route' => 'admin.caravans.index',
						'segment' => 'caravans',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read CaravanDates', 'write CaravanDates'],
                        'text'  => 'Caravan Rezeption',
                        'title' => 'Caravan Rezeption',
                        'icon'  => 'fas fa-concierge-bell',
                        'route' => 'admin.caravanDates.index',
						'segment' => 'caravanDates',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
/*
                    [
                        'permissions'   => ['read ConfigSaisonDates'],
                        'text'  => 'Saison-Daten',
                        'title' => 'Saison-Daten',
                        'icon'  => 'fas fa-gear',
                        'route' => 'admin.config-saisonDates-guests',
						'segment' => 'config-saisonDates-guests',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
*/
                ],
            ],
            'Gast Boote'   => [
                'permissions'   => ['read BoatsMenu'],
                'icon'  => 'fas fa-ship',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read GuestBoat','write GuestBoat'],
                        'text'  => 'Gäste',
                        'title' => 'Gäste',
                        'icon'  => 'fas fa-concierge-bell',
                        'route' => 'admin.guestBoats.index',
						'segment' => 'guestBoats',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read GuestBoatDates','write GuestBoatDates'],
                        'text'  => 'Gäste Rezeption',
                        'title' => 'Gäste Rezeption',
						'segment' => 'guestBoatDates',
                        'icon'  => 'fas fa-concierge-bell',
                        'route' => 'admin.guestBoatDates.index',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
/*
                    [
                        'permissions'   => ['read ConfigSaisonDates'],
                        'text'  => 'Saison-Daten',
                        'title' => 'Saison-Daten',
                        'icon'  => 'fas fa-gear',
                        'route' => 'admin.config-saisonDates-customers',
						'segment' => 'config-saisonDates-customers',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
*/
                ],
            ],
            'Dauerlieger'   => [
                'permissions'   => ['read BoatsMenu'],
                'icon'  => 'fas fa-ship',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Boat','write Boat'],
                        'text'  => 'Dauerlieger',
                        'title' => 'Dauerlieger',
                        'icon'  => 'fas fa-ship',
                        'route' => 'admin.boats.index',
						'segment' => 'boats',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read BoatDates','write BoatDates'],
                        'text'  => 'Dauer Liegeplätze',
                        'title' => 'Dauer Liegeplätze',
                        'icon'  => null,
                        'route' => 'admin.boatDates.index',
						'segment' => 'boatDates',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read CraneDate', 'write CraneDate'],
                        'text'  => 'Krantermine',
                        'title' => 'Krantermine',
                        'icon'  => 'fas fa-gear',
                        'route' => 'admin.craneDates.index',
						'segment' => 'craneDates',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read ConfigSaisonDates'],
                        'text'  => 'Saison-Daten',
                        'title' => 'Saison-Daten',
                        'icon'  => 'fas fa-gear',
                        'route' => 'admin.config-saisonDates-customers',
						'segment' => 'config-saisonDates-customers',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                ],
            ],
            'Boot Services' => [
                'permissions'   => ['read ServiceMenu'],
                'icon'  => 'fas fa-concierge-bell',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read ServiceRequest', 'write ServiceRequest'],
                        'text'  => 'Service Anfragen',
                        'title' => 'Service Anfragen',
                        'icon'  => 'fas fa-code-pull-request',
                        'route' => 'admin.serviceRequests.index',
						'segment' => 'serviceRequests',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Material', 'write Material'],
                        'text'  => 'Material',
                        'title' => 'Material',
                        'icon'  => 'fas fa-pump-soap',
                        'route' => 'admin.materials.index',
						'segment' => 'materials',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Service', 'write Service'],
                        'text'  => 'Service',
                        'title' => 'Service',
                        'icon'  => 'fab fa-servicestack',
                        'route' => 'admin.services.index',
						'segment' => 'services',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read ServiceCategory', 'write ServiceCategory'],
                        'text'  => 'Service Arten',
                        'title' => 'Service Arten',
                        'icon'  => 'far fa-window-restore',
                        'route' => 'admin.serviceCategories.index',
						'segment' => 'serviceCategories',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read MaterialCategory', 'write MaterialCategory'],
                        'text'  => 'Material Arten',
                        'title' => 'Material Arten',
                        'icon'  => 'far fa-window-restore',
                        'route' => 'admin.materialCategories.index',
						'segment' => 'materialCategories',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                ],
            ],
			'Häuser' => [
				'permissions'   => ['read RentalsMenu'],
				'icon'  => 'fa-solid fa-house-user',
				'hide_on_mobile' => false,
				'help'  => null,
				'items' => [
					[
						'permissions'   => ['read Rentable','write Rentable'],
						'text'  => 'Vermietung',
						'title' => 'Vermietung',
						'icon'  => 'fas fa-door-open',
						'route' => 'admin.houseRentals.index',
						'segment' => 'houseRentals',
						'hide_on_mobile' => false,
						'help'  => null,
					],
					[
						'permissions'   => ['read HouseModel','write HouseModel'],
						'text'  => 'Modelle',
						'title' => 'Modelle',
						'icon'  => 'fab fa-buromobelexperte',
						'route' => 'admin.houseModels.index',
						'segment' => 'houseModels',
						'hide_on_mobile' => true,
						'help'  => null,
					],
					[
						'permissions'   => ['read House','write House'],
						'text'  => 'Häuser',
						'title' => 'Häuser',
						'icon'  => 'fas fa-house',
						'route' => 'admin.houses.index',
						'segment' => 'houses',
						'hide_on_mobile' => true,
						'help'  => null,
					],
				],
			],
			'Apartments' => [
				'permissions'   => ['read RentalsMenu'],
				'icon'  => 'fa-solid fa-house-user',
				'hide_on_mobile' => false,
				'help'  => null,
				'items' => [
					[
						'permissions'   => ['read Rentable','write Rentable'],
						'text'  => 'Vermietung',
						'title' => 'Vermietung',
						'icon'  => 'fas fa-door-open',
						'route' => 'admin.apartmentRentals.index',
						'segment' => 'apartmentRentals',
						'hide_on_mobile' => false,
						'help'  => null,
					],
					[
						'permissions'   => ['read ApartmentModel','write ApartmentModel'],
						'text'  => 'Modelle',
						'title' => 'Modelle',
						'icon'  => 'fab fa-buromobelexperte',
						'route' => 'admin.apartmentModels.index',
						'segment' => 'apartmentModels',
						'hide_on_mobile' => true,
						'help'  => null,
					],
					[
						'permissions'   => ['read Apartment','write Apartment'],
						'text'  => 'Apartments',
						'title' => 'Apartments',
						'icon'  => 'far fa-building',
						'route' => 'admin.apartments.index',
						'segment' => 'apartments',
						'hide_on_mobile' => true,
						'help'  => null,
					],
				],
			],
            'Hausboote' => [
                'permissions'   => ['read RentalsMenu'],
                'icon'  => 'fa-solid fa-house-user',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Rentable','write Rentable'],
                        'text'  => 'Vermietung',
                        'title' => 'Vermietung',
                        'icon'  => 'fas fa-door-open',
                        'route' => 'admin.houseboatRentals.index',
						'segment' => 'houseboatRentals',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read HouseboatModel','write HouseboatModel'],
                        'text'  => 'Modelle',
                        'title' => 'Modelle',
                        'icon'  => 'fab fa-buromobelexperte',
                        'route' => 'admin.houseboatModels.index',
						'segment' => 'houseboatModels',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Rentals','write Rentals'],
                        'text'  => 'Hausboote',
                        'title' => 'Hausboote',
                        'icon'  => 'fas fa-house-flood-water',
                        'route' => 'admin.houseboats.index',
						'segment' => 'houseboats',
                        'hide_on_mobile' => true,
                        'help'  => null,
                    ],
                ],
            ],
            'Inhalt'   => [
                'permissions'   => ['read ContentMenu'],
                'icon'  => 'fas fa-newspaper',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Page', 'write Page'],
                        'text'  => 'Seiten',
                        'title' => 'Seiten',
                        'icon'  => 'far fa-file-lines',
                        'route' => 'admin.pages.index',
						'segment' => 'pages',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Widget', 'write Widget'],
                        'text'  => 'Widgets',
                        'title' => 'Widgets',
                        'icon'  => 'far fa-window-maximize',
                        'route' => 'admin.widgets.index',
						'segment' => 'widgets',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                ],
            ],
            'Rechte'   => [
                'permissions'   => ['read PermissionsMenu'],
                'icon'  => 'fas fa-user-lock',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read User', 'write User'],
                        'text'  => 'Users',
                        'title' => 'Users',
                        'icon'  => 'fas fa-user',
                        'route' => 'admin.users.index',
						'segment' => 'users',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Role', 'write Role'],
                        'text'  => 'Rollen',
                        'title' => 'Rollen',
                        'icon'  => 'fas fa-person-circle-plus',
                        'route' => 'admin.roles.index',
						'segment' => 'roles',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Permission', 'write Permission'],
                        'text'  => 'Berechtigungen',
                        'title' => 'Berechtigungen',
                        'icon'  => 'fas fa-person-military-pointing',
                        'route' => 'admin.permissions.index',
						'segment' => 'permissions',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                ],
            ],
            'Kunden'   => [
                'permissions'   => ['read CustomersMenu'],
                'icon'  => 'fas fa-user',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Customer', 'write Customer'],
                        'text'  => 'Dauerlieger',
                        'title' => 'Dauerlieger',
                        'icon'  => 'fas fa-user',
                        'route' => 'admin.customers.index',
						'segment' => 'customers',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Customer', 'write Customer'],
                        'text'  => 'Gastboote',
                        'title' => 'Gastboote',
                        'icon'  => 'fas fa-user',
                        'route' => 'admin.customers.guest',
						'segment' => 'customers',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Customer','write Customer'],
                        'text'  => 'Mieter',
                        'title' => 'Mieter',
                        'icon'  => 'fas fa-user',
                        'route' => 'admin.customers.renter',
						'segment' => 'customers',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Contact','write Contact'],
                        'text'  => 'Nachrichten',
                        'title' => 'Konzakt Anfragen',
                        'icon'  => 'fas fa-envelope-open-text',
                        'route' => 'admin.contacts.index',
						'segment' => 'contacts',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
/*
                    [
                        'permissions'   => ['read Customer','write Customer'],
                        'text'  => 'Haus',
                        'title' => 'Haus',
                        'icon'  => null,
                        'route' => 'admin.customers.houses',
                        'hide_on_mobile' => false,
                    ],
*/
                ],
            ],
            'Location' => [
                'permissions'   => ['read SettingsMenu'],
                'icon'  => 'fas fa-info-circle',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read ConfigSettings'],
                        'text'  => 'Einstellungen',
                        'title' => 'Einstellungen',
                        'icon'  => 'fas fa-gear',
                        'route' => 'admin.config-settings.index',
						'segment' => 'config-settings',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Dock'],
                        'text'  => 'Stege',
                        'title' => 'Boots Stege',
                        'icon'  => 'fas fa-anchor',
                        'route' => 'admin.docks.index',
						'segment' => 'docks',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read GuestBoatBerth'],
                        'text'  => 'Liegeplätze',
                        'title' => 'Boots Liegeplätze',
                        'icon'  => 'fas fa-ship',
                        'route' => 'admin.berths.index',
						'segment' => 'berths',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                ],
            ],
            'Einstellungen'   => [
                'permissions'   => ['read SettingsMenu'],
                'icon'  => 'fas fa-gear',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Offer'],
                        'text'  => 'Angebote',
                        'title' => 'Angebote',
                        'icon'  => 'fab fa-buffer',
                        'route' => 'admin.config-offers.index',
						'segment' => 'config-offers',
                        'hide_on_mobile' => true,
                        'help'  => 'Was soll alles angeboten werden?',
                    ],
                    [
                        'permissions'   => ['read ConfigBoatPrice'],
                        'text'  => 'Dauerlieger',
                        'title' => 'Dauerlieger-Preise',
                        'icon'  => 'fas fa-hand-holding-dollar',
                        'route' => 'admin.config-boatPrices.index',
						'segment' => 'config-boatPrices',
                        'hide_on_mobile' => true,
                        'help'  => 'Preisberechnung für Dauerlieger Boote',
                    ],
                    [
                        'permissions'   => ['read ConfigDailyPrice'],
                        'text'  => 'Gäste',
                        'title' => 'Gastboot/Caravan Preise',
                        'icon'  => 'fas fa-hand-holding-dollar',
                        'route' => 'admin.config-dailyPrices.index',
						'segment' => 'config-dailyPrices',
                        'hide_on_mobile' => true,
                        'help'  => 'Preisberechnung für Gäste. Dient sowohl für Caravans als auch für Gastboote',
                    ],
                    [
                        'permissions'   => ['read ConfigPriceComponent'],
                        'text'  => 'Komponenten',
                        'title' => 'Preis-Komponenten',
                        'icon'  => 'fas fa-hand-holding-dollar',
                        'route' => 'admin.config-priceComponents.index',
						'segment' => 'config-priceComponents',
                        'hide_on_mobile' => true,
                        'help'  => 'Dient zur Definition der Preisberechnung für verschiedene Dientsleistungen',
                    ],
                    [
                        'permissions'   => ['read ConfigSaisonRentDates'],
                        'text'  => 'SaisonDates',
                        'title' => 'SaisonDates',
                        'icon'  => 'fas fa-gear',
                        'route' => 'admin.config-saisonRentDates.index',
						'segment' => 'config-saisonRentDates',
                        'hide_on_mobile' => true,
                        'help'  => 'Alle periodischen Saisondaten für Mietobjekte.<br>An Hand dieser werden die jeweiligen Tagespreise berechnet',
                    ],
                ],
            ],
            'Admin'   => [
                'permissions'   => ['read SettingsMenu'],
                'icon'  => 'fas fa-lock',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Holidays'],
                        'text'  => 'Feiertage',
                        'title' => 'Feiertage',
                        'icon'  => 'fas fa-face-grin-hearts',
                        'route' => 'admin.config-holidays.index',
						'segment' => 'config-holidays',
                        'hide_on_mobile' => false,
                        'help'  => 'Feiertage, die bei der Berechnung von Tagespreisen von Mietobjekten berücksichtigt werden sollen.
                        Das betrifft nur neue Preisberechnungen, also keine bereits erfolgten Preisberechnungen.'
                    ],
                    [
                        'permissions'   => ['read ConfigServices'],
                        'text'  => 'Services',
                        'title' => 'Services',
                        'icon'  => 'fab fa-servicestack',
                        'route' => 'admin.config-services.index',
						'segment' => 'config-services',
                        'hide_on_mobile' => true,
                        'help'  => 'Alle Dienstleistungen, die angeboten werden',
                    ],
                    [
                        'permissions'   => ['read ConfigEntity'],
                        'text'  => 'Preis-Objekte',
                        'title' => 'Preis relevante Objekte',
                        'icon'  => 'fab fa-product-hunt',
                        'route' => 'admin.config-entities.index',
						'segment' => 'config-entities',
                        'hide_on_mobile' => false,
                        'help'  => 'Objekte, für die Preisberechnungen möglich sein sollen.',
                    ],
/*
                    [
                        'permissions'   => ['read ConfigSaisonRent'],
                        'text'  => 'Saisons',
                        'title' => 'Saisons',
                        'icon'  => 'fas fa-gear',
                        'route' => 'admin.config.saisonRents.index',
                        'hide_on_mobile' => true,
                        'help'  => 'Die Hauptsaison Daten',
                    ],
*/
                ],
            ],
            'Info'   => [
                'permissions'   => ['read InfoMenu'],
                'icon'  => 'fas fa-info-circle',
                'hide_on_mobile' => false,
                'help'  => null,
                'items' => [
                    [
                        'permissions'   => ['read Routes'],
                        'text'  => 'Routen',
                        'title' => 'Routen',
                        'icon'  => 'fas fa-route',
                        'route' => 'admin.infos.routes',
						'segment' => 'infos',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read Routes'],
                        'text'  => 'PHPInfo',
                        'title' => 'PHPInfo',
                        'icon'  => 'fab fa-php',
                        'route' => 'admin.infos.php',
						'segment' => 'infos',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                    [
                        'permissions'   => ['read AccessLog'],
                        'text'  => 'Test-Zugriffe',
                        'title' => 'Test-Zugriffe',
                        'icon'  => 'fas fa-right-to-bracket',
                        'route' => 'admin.accessLogs.index',
						'segment' => 'accessLogs',
                        'hide_on_mobile' => false,
                        'help'  => null,
                    ],
                ],
            ],
        ],
        'hide_on_mobile' => false,
    ],
];
