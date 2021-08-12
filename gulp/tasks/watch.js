module.exports = function () {
$.gulp.task('watch', function() {
    $.gulp.watch("./themes/muzyka21/src/css/*.scss",$.gulp.series("styles"));
    $.gulp.watch("./themes/muzyka21/src/js/**/*.js",$.gulp.series("scripts"));
    $.gulp.watch("./themes/muzyka21/src/js/*.js",$.gulp.series("scripts"));
});
}