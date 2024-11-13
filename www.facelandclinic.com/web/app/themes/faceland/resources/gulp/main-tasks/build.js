// Load required plugins
var gulp = require('gulp');

// // Build task
// // `gulp build` - Run all the build tasks but don't clean up beforehand.
// // `gulp build --production` - To compile for production run
module.exports = function(done) {
    // Run a sequence of tasks
    return gulp.series('clean', gulp.parallel('scripts', 'styles-build', 'images', 'eslint', 'fonts'))(done);
};
