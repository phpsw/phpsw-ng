var Encore = require('@symfony/webpack-encore');
var glob = require('glob-all');
var path = require('path');
var PurgecssPlugin = require('purgecss-webpack-plugin');

/**
 * Custom PurgeCSS Extractor
 * https://github.com/FullHuman/purgecss
 * https://github.com/FullHuman/purgecss-webpack-plugin
 */
class TailwindExtractor {
    static extract(content) {
        return content.match(/[A-z0-9-:\/]+/g);
    }
}

Encore
    .setOutputPath('./web/build')
    .setPublicPath('/')
    .cleanupOutputBeforeBuild()
    .enableLessLoader()
    .addStyleEntry('css/site', './app/resources/assets/less/main.less')
    .enablePostCssLoader(function(options) {
        options.config = {
            path: 'postcss.config.js'
        };
    })
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(false)
    .enableBuildNotifications()
;

// PurgeCSS
Encore.addPlugin(
    new PurgecssPlugin({
        paths: glob.sync([
            path.join(__dirname, "app/resources/views/**/*.twig")
        ]),
        extractors: [
            {
                extractor: TailwindExtractor,
                extensions: ['twig']
            }
        ]
    })
);

module.exports = Encore.getWebpackConfig();
