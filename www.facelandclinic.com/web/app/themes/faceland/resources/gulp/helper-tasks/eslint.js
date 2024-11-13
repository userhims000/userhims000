// Gulp eslint task
// `gulp eslint` - Lints configuration JSON and project JS.
module.exports = function($, gulp, manifest, settings) {
    return function() {
        var project = manifest.getProjectGlobs();

        return gulp
            .src(
                [
                    //'bower.json', 'gulpfile.js'
                ].concat(project.js)
            )
            .pipe($.changed('eslint'))
            .pipe($.eslint())
            .pipe($.eslint.format())
            .pipe($.if(settings.failEslint, $.eslint.failAfterError()));
    };
};
