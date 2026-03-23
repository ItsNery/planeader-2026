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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .webpackConfig(require('./webpack.config'))
    .browserSync({
        proxy: 'http://localhost:8000',
        files: [
            'app/**/*.php',
            'resources/views/**/*.blade.php',
            'public/js/**/*.js',
            'public/css/**/*.css'
        ]
    });

if (mix.inProduction()) {
    mix.version();
}
