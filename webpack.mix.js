const mix = require('laravel-mix');

const vueCustomsComponents = [
	'Sidebar',
//	'MyButton',
//	'MyFormErrors',
];
mix.autoload({
		'jquery': ['jQuery', '$'],
	})
	.js('resources/js/app.js', 'public/js')
	.js('resources/js/app-admin.js', 'public/js').vue({
		options: {
			compilerOptions: {
				isCustomElement: (tag) => vueCustomsComponents.includes(tag),
			},
		},
	})
	.js('node_modules/leaflet', 'public/js')
	.js('node_modules/leaflet-providers', 'public/js')
	.css('node_modules/leaflet/dist/leaflet.css', 'public/css')
	.css('node_modules/fullcalendar/main.min.css', 'public/css/fullcalendar.css')
	.sass('resources/sass/app.scss', 'public/css')
	.sass('resources/sass/print.scss', 'public/css')
	.sass('resources/sass/pdf.scss', 'public/css')
	.postCss('resources/css/app.css', 'public/css', [
		require('postcss-import'),
		require('tailwindcss'),
		require('autoprefixer'),
	])
	.copy('node_modules/fullcalendar/main.min.js', 'public/js/fullcalendar')
	.copy('node_modules/fullcalendar/locales-all.min.js', 'public/js/fullcalendar')
	.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
//	.copy('node_modules/material-design-icons', 'public/gicons')
	.copy('node_modules/froala-editor', 'public/froala-editor')
	.webpackConfig(require('./webpack.config'))
	.vue({version: 3})
;
