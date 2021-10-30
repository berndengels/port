<?php

return [
    /*
     * The dashboard supports these themes:
     *
     * - light: always use light mode
     * - dark: always use dark mode
     * - device: follow the OS preference for determining light or dark mode
     * - auto: use light mode when the sun is up, dark mode when the sun is down
     */
    'theme' => 'light',

    /*
     * When the dashboard uses the `auto` theme, these coordinates will be used
     * to determine whether the sun is up or down.
     */
    'auto_theme_location' => [
        'lat' => env('MIX_POSITION_LAT'),
        'lng' => env('MIX_POSITION_LNG'),
    ],

    /*
     * These scripts will be loaded when the dashboard is displayed.
     */
    'scripts' => [
        'alpinejs' => 'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
    ],

    /*
     * These stylesheets will be loaded when the dashboard is displayed.
     */
    'stylesheets' => [
        'inter' => 'https://rsms.me/inter/inter.css'
    ],
    'tiles' => [
        'time_weather' => [
            'open_weather_map_key' => env('MIX_WEATHER_API_KEY'),
            'open_weather_map_city' => 'Lütow',
            'open_weather_map_country_code' => 'DE',
            'units' => 'metric', // 'metric' or 'imperial' (metric is default)
//            'buienradar_latitude' => env('MIX_POSITION_LAT'),
//            'buienradar_longitude' => env('MIX_POSITION_LNG'),
        ],
    ],
];
