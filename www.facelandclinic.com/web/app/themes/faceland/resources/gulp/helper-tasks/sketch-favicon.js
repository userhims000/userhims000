var which = require('which');
var del = require('del');

// Gulp sketch-favicon task
// `gulp sketch-favicon` - Exports favicon sketch files to PNG files
module.exports = function($, gulp, manifest) {
    return function() {
        var functions = require('../functions/functions');
        var path = manifest.paths;
        var globs = manifest.globs;

        // Clean favicon directory
        // This task is not part of a bigger sequence so folder needs to be cleaned manually
        del([path.dist + 'favicons']);

        // Run sketch task
        var stream = gulp
            .src(path.source + 'sketch/favicons.sketch')

            // Export Sketch artboards to PNG files
            .pipe(
                $.sketch({
                    export: 'artboards',
                    formats: 'png'
                })
            )

            // Optimize images and SVG files
            .pipe(
                $.imagemin({
                    progressive: true,
                    interlaced: true
                })
            )

            .pipe(gulp.dest(path.dist + 'images'));

        return stream;
    };
};
