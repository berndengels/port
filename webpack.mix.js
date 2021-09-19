const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix
    .vue({version: 3})
    .js('resources/js/app.js', 'public/js')
    .js('node_modules/leaflet', 'public/js')
    .js('node_modules/leaflet-providers', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .css('node_modules/leaflet/dist/leaflet.css', 'public/css')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/pdf.scss', 'public/css')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .webpackConfig(require('./webpack.config'))
//    .browserSync({proxy: process.env.MIX_API_URL})
;

if (mix.inProduction()) {
    mix.version();
}
