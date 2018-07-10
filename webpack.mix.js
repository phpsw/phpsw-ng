let mix = require('laravel-mix');
let glob = require("glob-all");
let PurgecssPlugin = require("purgecss-webpack-plugin");

require('laravel-mix-tailwind');

mix.disableNotifications()
    .less('app/resources/assets/less/main.less', 'web/build/css/site.css')
    .copyDirectory('app/resources/assets/static', 'web/build/static')
    .copyDirectory('node_modules/font-awesome/fonts', 'web/build/fonts')
    .tailwind()
    .options({
        processCssUrls: false
    })
    .webpackConfig({
        plugins: [
            new PurgecssPlugin({
                paths: glob.sync([
                    path.join(__dirname, "app/resources/views/**/*.twig")
                ]),
                extractors: [
                    {
                        extractor: class {
                            static extract(content) {
                                return content.match(/[A-z0-9-:\/]+/g)
                            }
                        },
                        extensions: ["twig"]
                    }
                ]
            })
        ]
    });
