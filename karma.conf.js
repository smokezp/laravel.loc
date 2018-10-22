// Karma configuration
// Generated on Mon Oct 22 2018 10:31:22 GMT+0300 (EEST)
var webpackConfig = require('./webpack.config.js')

module.exports = function (config) {
    config.set({

        // base path that will be used to resolve all patterns (eg. files, exclude)
        basePath: '',

        plugins: [
            require('karma-jasmine'),
            require('karma-webpack'),
            require('karma-phantomjs-launcher'),
            require('karma-coverage'),
            // require('karma-phantomjs-launcher'),
            // require('karma-sourcemap-loader'),




            // require('karma-jasmine-html-reporter'),
            // require('karma-coverage-istanbul-reporter'),
            // require('@angular/cli/plugins/karma')
            // require('webpack'),

        ],
        // frameworks to use
        // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
        frameworks: ['jasmine'],


        // list of files / patterns to load in the browser
        files: [
            {pattern: 'resources/js/tests/**/*.spec.js', watch: false},
            {pattern: 'resources/js/components/**/*.vue', watch: false},
            {pattern: 'resources/js/*.js', watch: false},
            // 'components/**/*.vue'
        ],


        // list of files / patterns to exclude
        exclude: [],


        // preprocess matching files before serving them to the browser
        // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
        preprocessors: {
            'resources/js/tests/**/*spec.js': ['webpack'],
            'resources/js/components/**/*.vue': ['webpack', 'coverage'],
            'resources/js/*.js': ['webpack', 'coverage'],
            // 'components/**/*.vue': ['webpack'],
        },
        webpack: webpackConfig,

        // test results reporter to use
        // possible values: 'dots', 'progress'
        // available reporters: https://npmjs.org/browse/keyword/karma-reporter
        reporters: ['progress', 'coverage'],


        coverageReporter: {
            dir: './coverage',
            reporters: [
                { type: 'lcov', subdir: '.' },
                { type: 'text-summary' }
            ]
        },

        // web server port
        port: 9876,


        // enable / disable colors in the output (reporters and logs)
        colors: true,


        // level of logging
        // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
        logLevel: config.LOG_INFO,


        // enable / disable watching file and executing tests whenever any file changes
        autoWatch: false,


        // start these browsers
        // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
        browsers: ['PhantomJS'],
        customLaunchers: {
            // PhantomJS_custom
            'PhantomJS_custom': {
                base: 'PhantomJS',
                options: {
                    windowName: 'my-window',
                    settings: {
                        webSecurityEnabled: false
                    }
                },
                flags: ['--load-images=true'],
                debug: true
            }
        },

        phantomjsLauncher: {
            exitOnResourceError: true
        },

        // Continuous Integration mode
        // if true, Karma captures browsers, runs the tests and exits
        singleRun: true,

        // Concurrency level
        // how many browser should be started simultaneous
        concurrency: Infinity
    })
};
