const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/admin/js');

mix.styles(['resources/backend/css/dropzone.min.css'], 'public/admin/dist/css/dropezone.css')
    .scripts(['resources/backend/js/dropzone.min.js'], 'public/admin/dist/js/dropezone.js');
