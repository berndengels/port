const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .css('resources/css/app.css', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
;
