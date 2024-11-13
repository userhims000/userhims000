// Load required plugins
var browserSync = require('browser-sync');
var fs = require('fs');

// `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
// Generally you should be running `gulp` instead of `gulp watch`.
module.exports = function($, gulp, manifest, done) {
    // Load main helper functions
    var path = manifest.paths;
    var localConfig = JSON.parse(fs.readFileSync('./localconfig.json'));
    var devUrl = localConfig.environment.devUrl;

    function watchTask() {
        gulp.watch(path.source + 'sketch/*.sketch', gulp.series('sketch'));
        gulp.watch(path.source + 'styles/**/*', gulp.parallel('stylelint', 'styles'));
        gulp.watch(path.source + 'scripts/**/*', gulp.parallel('eslint', 'scripts'));
        gulp.watch(path.source + 'images/**/*', gulp.series('images'));
        gulp.watch(path.source + 'fonts/**/*', gulp.series('fonts'));
        gulp.watch('source/manifest.json', gulp.series('build'));
    }

    function browserSyncTask() {
        browserSync({
            files: [path.dist + '**/*', '{lib,templates}/**/*.php', '*.php', 'resources/**/*.twig', '*.twig'],
            proxy: devUrl,
            open: false
        });
    }

    return gulp.parallel(watchTask, browserSyncTask)(done);
};
