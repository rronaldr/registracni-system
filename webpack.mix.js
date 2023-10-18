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

mix.webpackConfig({
    experiments: {
        topLevelAwait: true
    }})
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/datatables-cs.js', 'public/js')
    .js('resources/js/datatables-en.js', 'public/js')
    .vue({ version: 3})
    .version();
