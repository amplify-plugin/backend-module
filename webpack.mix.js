const mix = require('laravel-mix');
const webpack = require('webpack');
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


mix.options({
    processCssUrls: false,
    notifications: {
        onSuccess: false,
    },
    clearConsole: true,
    terser: {
        extractComments: false,
        terserOptions: {
            format: {
                comments: false,
            },
        },
    },
}).setPublicPath('public')
    .sass('resources/scss/backend.scss', 'public/css/backend.css')
    .copyDirectory('resources/js', 'public/js/')
    .copyDirectory('resources/css', 'public/css/')
    .copyDirectory('resources/img', 'public/img/')
    .js('resources/vue/app.js', 'public/js/backend.js')
    .vue()
    .copy('resources/js/crud.js', 'public/js/crud.js')
    .webpackConfig({
        resolve: {
            fallback: {
                buffer: require.resolve('buffer/'), // Polyfill for buffer
            },
        },
        plugins: [
            new webpack.ProvidePlugin({
                Buffer: ['buffer', 'Buffer'], // Provide Buffer globally
            }),
        ],
        output: {
            chunkFilename: 'js/[name].js',
            publicPath: '/vendor/backend/',
        }
    }).version();

