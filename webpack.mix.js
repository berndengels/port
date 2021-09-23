const mix = require('laravel-mix');

mix
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
;
