module.exports = function (config) {
    'use strict';

    // Retrieve a Webpack config specialized in tests
    var webpackConfig = require('../../webpack.config');
    webpackConfig.context = __dirname + '/../..';
    delete webpackConfig.entry;
    delete webpackConfig.output;

    config.set({
        basePath: '../',
        browsers: [process.env.CI ? 'PhantomJS' : 'Chrome'],
        frameworks: ['jasmine'],
        files: [
            '../bower_components/ng-admin/build/ng-admin.min.js',
            '../node_modules/angular-mocks/angular-mocks.js',
            'test/function.bind.shim.js',
            'test/unit/**/*.js'
        ],
        plugins: ['karma-webpack', 'karma-jasmine', 'karma-chrome-launcher', 'karma-phantomjs-launcher'],
        preprocessors: {
            'test/unit/**/*.js': 'webpack',
            'source/**/*.js': 'webpack',
        },
        webpackMiddleware: {
            noInfo: true,
            devtool: 'inline-source-map' //just do inline source maps instead of the default
        },
        webpack: webpackConfig
    });
};
