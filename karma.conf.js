// var webpackConfig = require('./webpack.config.js')

module.exports = function (config) {
    config.set({
        frameworks: ['mocha'],

        files: [
            'resources/js/tests/**/*.spec.js'
        ],

        preprocessors: {
            '**/*.spec.js': ['webpack', 'sourcemap']
        },

        // webpack: webpackConfig,

        reporters: ['spec'],

        browsers: ['PhantomJS'],

        coverageReporter: {
            dir: './coverage',
            reporters: [
                { type: 'lcov', subdir: '.' },
                { type: 'text-summary' }
            ]
        }
    })
};
