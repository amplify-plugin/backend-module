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
    hmrOptions: {
        host: 'localhost', // or your local IP / domain
        port: 8000         // change this to any port you want
    }
})
    .setPublicPath('public')
    .setResourceRoot('resources')
    .sass('resources/scss/backend.scss', 'public/css/backend.css')
    .copyDirectory('resources/js', 'public/js/')
    .copyDirectory('resources/css', 'public/css/')
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
            publicPath: 'http://localhost:8000/vendor/backend/',
        }
    })
    .browserSync({
        proxy:'http://localhost:8000',
        host: 'localhost',
        port: 3000,
        open: false,
        files : [
            'src/**/*.php',
            'resources/views/**/*.php',
            'public/**/*.js',
            'public/**/*.css'
        ]
    })
    .version();
