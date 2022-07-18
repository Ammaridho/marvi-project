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

//mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');

//mix.combine('public/arvi/assets/js/script.js')

// Combine all vendor
mix.js([
    'public/arvi/assets/js/scrolloverflow.min.js',
    'public/arvi/assets/js/fullpage.min.js',
    'public/arvi/assets/js/calendar.min.js',
], 'public/arvi/assets/js/vend-ffotf.js')
    .minify('public/arvi/assets/js/vend-ffotf.js').version();

mix.js([
    'public/arvi/assets/js/script.js',
    'public/arvi/assets/js/otf-case.js',
    'public/arvi/assets/js/locaware.js',
], 'public/arvi/assets/js/ffotf.js')
    .minify('public/arvi/assets/js/ffotf.js').version();
