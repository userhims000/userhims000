// Gulp scsslint task
// `gulp scsslint` - Lints all SCSS files by rules defined in scss-lint.yml
module.exports = function($, gulp, manifest, settings) {
    return function() {
        var functions = require('../functions/functions');
        var path = manifest.paths;

        gulp.src([
            path.source + 'styles/**/*.scss', // Include all scss files
            '!' + path.source + 'styles/plugins/**/*.scss', // Exclude plugins
            '!' + path.source + 'styles/modules/_modules.shame.scss' // Exclude shame.scss
        ])

            .pipe($.cached('scsslint')) // Only lint changed files
            .pipe($.scsslint({ config: '.scss-lint.yml' })) // Lint SCSS files

            // Development error reporter, never fails
            .pipe($.if(!settings.failScsslint, $.scsslint.reporter(functions.gulpReporter))) // Report errors with custom gulpReporter

            // Production reporter (default) and fails on error
            .pipe($.if(settings.failScsslint, $.scsslint.reporter()))
            .pipe($.if(settings.failScsslint, $.scsslint.reporter('fail')));
    };
};
