// Gulp Images task
// `gulp images` - Run lossless compression on all the images.
module.exports = function($, gulp, manifest) {
    return function() {
        var path = manifest.paths;
        var globs = manifest.globs;
        var cache = require('gulp-cached');
        var stream = gulp
            .src(globs.images)

            // Only run for changed files
            .pipe($.changed(path.dist + 'images'))

            // Optimize images and SVG files
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
