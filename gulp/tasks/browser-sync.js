module.exports = function () {
	$.gulp.task("browser-sync", function () {
		$.browserSync.init({
				proxy: "muz21.local",
		});
	});
};
