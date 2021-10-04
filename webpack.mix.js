const mix = require('laravel-mix');

mix.autoload({
		'jquery': ['jQuery', '$']
	})
	.js('resources/js/app.js', 'public/js')
	.js('resources/js/app-admin.js', 'public/js')
	.js('node_modules/leaflet', 'public/js')
	.js('node_modules/leaflet-providers', 'public/js')
	.css('node_modules/leaflet/dist/leaflet.css', 'public/css')
	.sass('resources/sass/app.scss', 'public/css')
	.sass('resources/sass/pdf.scss', 'public/css')
	.postCss('resources/css/app.css', 'public/css', [
		require('postcss-import'),
		require('tailwindcss'),
		require('autoprefixer'),
	])
	.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
	.copy('node_modules/froala-editor', 'public/froala-editor')
	.webpackConfig(require('./webpack.config'))
;
