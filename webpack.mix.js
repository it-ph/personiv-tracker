const { mix } = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
	.js('resources/assets/js/app.js', 'public/js')
   	.sass('resources/assets/sass/app.scss', 'public/css')

   	// Vendor CSS
   .styles([
         'public/css/vendor/animate.css',
         'public/css/vendor/highcharts.css',
   		'public/css/vendor/highcharts-ng.css',
   		'public/css/vendor/angular-material.css',
   		'public/css/vendor/materialdesignicons.css'
   	], 'public/css/vendor.css')

   	// Vendor Scripts
   .scripts([
         'public/js/vendor/jquery.js',
   		'public/js/vendor/angular.js',
         'public/js/vendor/moment.js',
         'public/js/vendor/highcharts.js',
   		'public/js/vendor/highcharts-ng.js',
   		'public/js/vendor/pusher.js',
   		'public/js/vendor/angular-aria.js',
         'public/js/vendor/angular-file-upload.js',
   		'public/js/vendor/angular-animate.js',
   		'public/js/vendor/angular-material.js',
   		'public/js/vendor/angular-messages.js',
   		'public/js/vendor/angular-moment.js',
   		'public/js/vendor/angular-ui-router.js',
   		'public/js/vendor/ng-infinite-scroll.js',
   	], 'public/js/vendor.js')

   .sass('resources/assets/sass/app/app.scss', 'public/css/application.css')

	// Shared Scripts
   .scripts([
         'public/app/shared/*.js',
         'public/app/shared/factories/*.js',
   		'public/app/shared/factories/**/*.js',
         'public/app/shared/controllers/*.js',
         'public/app/shared/controllers/**/*.js',
   	], 'public/js/shared.js')

   // Auth Scripts
   .scripts([
         'public/app/auth/*.js',
         'public/app/auth/controllers/*.js',
      ], 'public/js/auth.js') 

	// Admin Scripts
   .scripts([
         'public/app/admin/*.js',
         'public/app/admin/factories/*.js',
   		'public/app/admin/factories/**/*.js',
         'public/app/admin/controllers/*.js',
         'public/app/admin/controllers/**/*.js',
   	], 'public/js/admin.js')

   	// Employee Scripts
   .scripts([
         'public/app/employee/*.js',
         'public/app/employee/factories/*.js',
   		'public/app/employee/factories/**/*.js',
         'public/app/employee/controllers/*.js',
         'public/app/employee/controllers/**/*.js',
   	], 'public/js/employee.js')
