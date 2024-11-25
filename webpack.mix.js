const mix = require('laravel-mix');

mix.disableNotifications();
const vueCustomsComponents = [
	'Sidebar',
//	'MyButton',
	'MyFormErrors',
];
mix.autoload({
		'jquery': ['jQuery', '$'],
	})
	.copy('node_modules/tinymce', 'public/tinymce')
	.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
	.copy('node_modules/tinymce', 'public/tinymce')
	.copy('node_modules/dropzone/dist', 'public/dropzone')
	.copy('resources/js/vendor/jquery.mobile/jquery.mobile-1.4.5.js', 'public/jquery-mobile')
	.copy('resources/js/vendor/jquery.mobile/jquery.mobile-1.4.5.css', 'public/jquery-mobile')
	.copy('resources/js/vendor/jquery.mobile/jquery.mobile-1.4.5.min.js', 'public/jquery-mobile')
	.copy('resources/js/vendor/jquery.mobile/jquery.mobile-1.4.5.min.css', 'public/jquery-mobile')
	.js('resources/js/app.js', 'public/js')
	.js('resources/js/app-admin.js', 'public/js')
	.js('resources/js/app-customer.js', 'public/js')
	.js('node_modules/leaflet', 'public/js')
	.js('node_modules/konva', 'public/js')
	.js('node_modules/leaflet-providers', 'public/js')
	.css('node_modules/leaflet/dist/leaflet.css', 'public/css')
	.sass('resources/sass/app-admin.scss', 'public/css')
	.sass('resources/sass/app-customer.scss', 'public/css')
	.sass('resources/sass/app.scss', 'public/css')
	.sass('resources/sass/print.scss', 'public/css')
	.sass('resources/sass/pdf.scss', 'public/css')
	.options({processCssUrls: false})
	.webpackConfig(require('./webpack.config'))
	.vue({
		version: 3,
		options: {
			compilerOptions: {
				isCustomElement: (tag) => vueCustomsComponents.includes(tag),
			},
		},
	})
;
