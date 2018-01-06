var Encore = require('@symfony/webpack-encore');

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

module.exports = Encore.getWebpackConfig();
