const mix = require('laravel-mix');
const webpack = require('webpack');
const path = require("path");
const fs = require("fs");
const {exec} = require("child_process");
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

class PublishBackendAssets {
    apply(compiler) {
        compiler.hooks.done.tap('RunCommandIfArtisanExists', (stats) => {
            if (stats.hasErrors()) return;

            // adjust path relative to your webpack.mix.js
            const artisanPath = path.resolve(__dirname, '../../artisan');

            if (fs.existsSync(artisanPath)) {
                exec('php ../../artisan vendor:publish --tag=backend-asset --ansi --force', (err, stdout, stderr) => {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    console.log(stdout);
                });
            } else {
                console.log('artisan file not found, skipping...');
            }
        });
    }
}

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
    .copyDirectory('resources/ckeditor/assets', 'public/ckeditor')
    .js('resources/js/ckeditor/ckeditor-browser.js', 'public/ckeditor/ckeditor-config.js')
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
            new PublishBackendAssets(),
        ],
        output: {
            chunkFilename: 'js/[name].js',
            publicPath: '/vendor/backend/',
        }
    }).version();

