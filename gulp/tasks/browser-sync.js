module.exports = function () {
	$.gulp.task("browser-sync", function () {
		$.browserSync.init({
				proxy: "muz21.local",
		});

		$.gulp.watch("./themes/muzyka21/src/css/*.scss",$.gulp.series("styles"));
		$.gulp.watch("./themes/muzyka21/src/js/**/*.js",$.gulp.series("scripts"));
		$.gulp.watch("./themes/muzyka21/src/js/*.js",$.gulp.series("scripts"));
	});
};
