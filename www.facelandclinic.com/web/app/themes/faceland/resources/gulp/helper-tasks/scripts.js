// Load required plugins
var merge = require('merge-stream');
var lazypipe = require('lazypipe');
var babel = require('gulp-babel');

// Gulp Scripts task
// `gulp scripts` - Runs Eslint then compiles, combines, and optimizes Bower JS and project JS.
module.exports = function($, gulp, manifest, settings) {
    return function() {
        var config = manifest.config || {};

        // Load main helper functions
        var helpers = require('../functions/functions');

        // Merge all JS dependencies
        var merged = merge();
        manifest.forEachDependency('js', function(dep, done) {
            merged.add(gulp.src(dep.globs, { base: 'scripts' }).pipe(jsTasks(dep.name, settings, $, config)));
        });

        // Return and write to manifest
        merged.pipe(helpers.writeToManifest('scripts', settings));

        return merged;
    };
};

// JS processing pipeline
var jsTasks = function(filename, settings, $, config) {
    return (
        lazypipe()
            // Init source maps
            // Only if NOT --production flag
            .pipe(function() {
                return $.if(settings.maps, $.sourcemaps.init());
            })

            // Concat files
            .pipe($.concat, filename)

            .pipe(function() {
                return $.if(
                    filename !== 'vendors.js' &&
                        filename !== 'vendors-main.js' &&
                        filename !== 'vendors-webshop.js' &&
                        filename !== 'jquery.js',
                    $.babel({
                        plugins: [
                            '@babel/plugin-proposal-class-properties',
                            'babel-plugin-private-underscores',
                            '@babel/plugin-proposal-optional-chaining'
                        ],
                        presets: ['@babel/env']
                    }).on('error', console.error.bind(console))
                );
            })

            // Uglify JS
            // Only with --production flag
            .pipe(function() {
                return $.if(settings.uglify, $.terser());
            })

            // Remove console and debug messages
            // Only with --production flag
            .pipe(function() {
                return $.if(settings.failEslint, $.stripDebug());
            })

            // Add revision numbering if --production flag is set
            .pipe(function() {
                return $.if(settings.rev, $.rev());
            })

            // Write source maps
            // Only if NOT --production flag
            .pipe(function() {
                return $.if(settings.maps, $.sourcemaps.write('.'));
            })()
    );
};
