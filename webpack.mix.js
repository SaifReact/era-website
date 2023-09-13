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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/clients.js', 'public/js')
    .js('resources/js/testimonials.js', 'public/js')
    .js('resources/js/portfolios.js', 'public/js')
    .js('resources/js/front.js', 'public/js');
mix.sass('resources/scss/app.scss', 'public/css', [
    //
]);
mix.sass('resources/scss/pages.scss', 'public/css', [
    //
]);
mix.js('resources/js/admin/app.js', 'public/js/admin').vue();
mix.js('resources/js/admin/login.js', 'public/js/admin');
mix.sass('resources/scss/admin/app.scss', 'public/css/admin', [
    //
]).sass('resources/scss/admin/login.scss', 'public/css/admin', [
    //
])/*.postCss('resources/css/app.css', 'public/css', [
        //
    ])*/
    .postCss('resources/css/front.css', 'public/css', [
        //
    ])
    .postCss('resources/css/error.css', 'public/css', [
        //
    ])
    .copyDirectory('resources/images', 'public/images');

if (mix.inProduction()) {
    mix.version();
}
