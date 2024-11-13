// Gulp Fonts task
// `gulp fonts` - Copy all fonts from source directory to assets directory
// @TODO needs to be updated later when new font loading is active
module.exports = function($, gulp, manifest) {
    return function() {
        var path = manifest.paths;
        var globs = manifest.globs;

        var stream = gulp
            .src(globs.fonts)

            .pipe(gulp.dest(path.dist + 'fonts'));

        return stream;
    };
};
