let mix = require('laravel-mix');

require('laravel-mix-purgecss');
require('laravel-mix-tailwind');

mix.disableNotifications()
    .less('app/resources/assets/less/main.less', 'web/build/css/site.css')
    .copyDirectory('app/resources/assets/static', 'web/build/static')
    .copyDirectory('node_modules/font-awesome/fonts', 'web/build/fonts')
    .tailwind()
    .options({
        processCssUrls: false
    })
    .purgeCss({
        globs: [
            path.join(__dirname, 'app/resources/views/**/*.twig'),
        ],
        whitelistPatterns: [/language/, /hljs/],
        whitelistPatternsChildren: [/^markdown$/]
    });
