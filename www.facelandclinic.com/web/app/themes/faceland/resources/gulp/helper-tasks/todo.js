// Gulp Todo task
// `gulp todo` - Search project for @TODO and generate a todo.md (php, JS, SCSS)
module.exports = function($, gulp, manifest) {
    return function() {
        var path = manifest.paths;

        var stream = gulp
            .src(['**/*.php', 'gulpfile.js', path.source + 'styles/**/*', path.source + 'scripts/**/*'])
            .pipe($.todo())
            .pipe(gulp.dest('./'));
        return stream;
    };
};
