var which = require('which');
var cache = require('gulp-cached');

// Gulp sketch-favicon task
// `gulp sketch-favicon` - Exports favicon sketch files to PNG files
module.exports = function($, gulp, manifest, done) {
    return function() {
        var functions = require('../functions/functions');
        var path = manifest.paths;
        var globs = manifest.globs;

        // This task needs sketchtool
        // Please download and install
        // http://bohemiancoding.com/sketch/tool/
        // For installation manual
        // https://news.layervault.com/stories/21828-sketchtool--a-commandline-app-for-exporting-pages-and-slices-out-of-sketch-docs
        try {
            which.sync('sketchtool');
        } catch (error) {
            return new Promise(function(resolve, reject) {
                console.log('No sketchtool found');
                resolve();
            });
        }

        // Import sketch files stream
        // @TODO sketch saves the file twice for some reason. See http://stackoverflow.com/questions/21608480/gulp-js-watch-task-runs-twice-when-saving-files
        var stream = gulp
            .src(path.source + 'sketch/assets.sketch')

            // Only run for changed files
            .pipe(cache('sketch'))

            // Export Sketch artboards to SVG/PNG files
            .pipe(
                $.sketch({
                    export: 'artboards',
                    formats: 'svg',
                    saveForWeb: true,
                    scales: 1.0,
                    trimmed: true
                })
            )

            // Optimize exported images and SVG files
            .pipe(
                $.imagemin({
                    progressive: true,
                    interlaced: true,
                    svgoPlugins: [{ removeUnknownsAndDefaults: false }]
                })
            )

            .pipe(gulp.dest(path.dist + 'images'));

        return stream;
    };
};
