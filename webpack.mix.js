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

const path = require('path');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/js').vue()

mix.webpackConfig({
    plugins: [
        new webpack.IgnorePlugin({resourceRegExp: /^\.\/locale$/, contextRegExp: /moment$/ })
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js')
        },
    },
});
    