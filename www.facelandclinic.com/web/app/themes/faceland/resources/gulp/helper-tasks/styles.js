// Load plugins
var gulp = require('gulp');
var sass = require('gulp-sass');
var plumber = require('gulp-plumber');
var browserSync = require('browser-sync');
var autoprefixer = require('gulp-autoprefixer');
var combineMq = require('gulp-combine-mq');

// Generally you should be running `gulp` instead of `gulp watch`.
module.exports = function($, gulp, manifest) {
    return function() {
        // Load main helper functions
        var path = manifest.paths;
        var config = manifest.config || {};

        var stream = gulp
            .src(path.source + 'styles/*.scss')
            .pipe(plumber())
            .pipe(sass().on('error', sass.logError))
            .pipe(
                autoprefixer(),
                {
                    browsers: config.supportedBrowsers
                }
            )
            .pipe(combineMq())
            .pipe(gulp.dest(path.dist + '/styles'))
            .pipe(browserSync.stream());

        return stream;
    };
};
