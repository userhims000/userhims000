/**
 * Load required plugins
 *
 */

var $ = require('gulp-load-plugins')(); // Load all gulp plugins automatically
var argv = require('minimist')(process.argv.slice(2));
var gulp = require('gulp');

/**
 * Define variables
 */

var gulpRoute = './resources';

// Use a project based manifest file for asset pipeline
// See https://github.com/austinpray/asset-builder
var manifest = require('asset-builder')(gulpRoute + '/source/manifest.json');

var path = manifest.paths; // `path` - Paths to base asset directories.
var config = manifest.config || {}; // `config` - Store arbitrary configuration values here.
var globs = manifest.globs; // `globs` - Array of assets path globs
var project = manifest.getProjectGlobs(); // `project` - paths to first-party assets.

// Options for CLI flags
var settings = {
    rev: argv.production, // Enable static asset revisioning when `--production`
    maps: !argv.production, // Disable source maps when `--production`
    notifications: !argv.production, // Disable notifications when `--production`
    failScsslint: argv.production, // Fail on scss lint errors `--production`
    failEslint: argv.production, // Fail on scss lint errors `--production`
    failStyleTask: argv.production, // Fail styles task on error when `--production`
    uglify: argv.production, // Uglify JS when `--production`
    notify: !argv.production
};

/**
 * Import helper tasks
 */

gulp.task('scripts', require(gulpRoute + '/gulp/helper-tasks/scripts')($, gulp, manifest, settings));
gulp.task('eslint', require(gulpRoute + '/gulp/helper-tasks/eslint')($, gulp, manifest, settings));
gulp.task('styles', require(gulpRoute + '/gulp/helper-tasks/styles')($, gulp, manifest, settings));
gulp.task('styles-build', require(gulpRoute + '/gulp/helper-tasks/styles-build')($, gulp, manifest, settings));
gulp.task('stylelint', require(gulpRoute + '/gulp/helper-tasks/stylelint')($, gulp, manifest, settings));
gulp.task('images', require(gulpRoute + '/gulp/helper-tasks/images')($, gulp, manifest));
gulp.task('sketch-favicon', require(gulpRoute + '/gulp/helper-tasks/sketch-favicon')($, gulp, manifest));
gulp.task('sketch', require(gulpRoute + '/gulp/helper-tasks/sketch')($, gulp, manifest));
gulp.task('todo', require(gulpRoute + '/gulp/helper-tasks/todo')($, gulp, manifest));
gulp.task('fonts', require(gulpRoute + '/gulp/helper-tasks/fonts')($, gulp, manifest, settings));
gulp.task('clean', require('del').bind(null, [path.dist]));

/**
 * Import main tasks
 */

// `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
// Generally you should be running `gulp` instead of `gulp watch`.
gulp.task('watch', function(done) {
    require(gulpRoute + '/gulp/main-tasks/watch')($, gulp, manifest, done);
    done();
});

// Build task
// `gulp build` - Run all the build tasks but don't clean up beforehand.
// `gulp build --production` - To compile for production run
gulp.task('build', function(done) {
    require(gulpRoute + '/gulp/main-tasks/build')(done);
    done();
});

// Gulp default task
// `gulp` - Run a complete build and start watch task.
gulp.task('default', gulp.series('build', 'watch'));
