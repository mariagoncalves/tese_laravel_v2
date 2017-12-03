let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/metisMenu.min.css',
    'resources/assets/css/sb-admin-2.css',
    'resources/assets/css/custombtns.css',
    'resources/assets/css/plugins/morris.css',
    'resources/assets/css/font-awesome.min.css',
    'resources/assets/css/angular-growl.css',
    'resources/assets/css/loading-bar.min.css',
    'resources/assets/css/select2.min.css',
    'resources/assets/css/select.css',
    'resources/assets/css/ng-table.min.css'
], 'public/css/app.css');

mix.scripts([
    'resources/assets/js/jquery.js',
    'resources/assets/js/jquery.js',
    'resources/assets/js/angular.min.js',
    'resources/assets/js/angular-route.min.js',
    'resources/assets/js/angular-animate.min.js',
    'resources/assets/js/angular-sanitize.min.js',
    'resources/assets/js/angular-aria.min.js',
    'resources/assets/js/angular-messages.min.js',
    'resources/assets/js/select.js',
    'resources/assets/js/angular-growl.min.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/sortable.min.js',
    'resources/assets/js/angular-translate.min.js',
    'resources/assets/js/angular-translate-loader-partial.min.js',
    'resources/assets/js/ui-bootstrap-tpls-2.5.0.min.js',
    'resources/assets/js/angular-file-upload.js',
    'resources/assets/js/loading-bar.min.js',
    'resources/assets/js/select2.min.js',
    'resources/assets/js/ng-table.min.js',
    'resources/assets/js/metisMenu/metisMenu.min.js',
    'resources/assets/js/sb-admin-2.js'
], 'public/js/app.js');
