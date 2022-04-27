const path = require('path');
const mix = require('laravel-mix');
const ASSET_URL =process.env.ASSET_URL !== undefined? process.env.ASSET_URL+"/":"/";



mix.webpackConfig({
   resolve: {
      alias: {
          '@': path.resolve(__dirname, 'frontend/src/'),
      }
   }
});



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
   .sass('resources/sass/app.scss', 'public/css');

mix.copy('frontend/public', 'public');

mix.webpackConfig(webpack => {
    return {
        output: {
            publicPath: ASSET_URL
        },
        plugins: [
            new webpack.DefinePlugin({
                "process.env.ASSET_PATH": JSON.stringify(ASSET_URL)
            })
        ]
    };
});
