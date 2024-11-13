// Gulp Stylelint task
var plumber = require("gulp-plumber");
var gulpStylelint = require("gulp-stylelint");

module.exports = function($, gulp, manifest) {
    return function() {
        var functions = require("../functions/functions");
        var path = manifest.paths;

        return gulp
            .src([
                path.source + "styles/**/*.scss",
                "!" + path.source + "styles/debug/*.scss",
                "!" + path.source + "styles/vendors/*.scss",
                "!" + path.source + "styles/settings/*.scss",
                "!" + path.source + "styles/print.scss"
            ])
            .pipe(plumber())
            .pipe(
                gulpStylelint({
                    reporters: [{ formatter: "string", console: true }]
                })
            );
    };
};
