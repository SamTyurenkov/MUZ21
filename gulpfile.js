"use strict";

global.$ = {
    path: {
        task: require('./gulp/path/tasks.js')
    },
    gulp: require('gulp'),
    del: require('del')
};

$.path.task.forEach(function (taskPath) {
    require(taskPath)();
});

$.gulp.task('default', $.gulp.series(
    $.gulp.parallel(
        'styles',
        'scripts:site',
        'scripts:gutenberg',
        'scripts:authors',
        'imgs'
    )
));

$.gulp.task('styles', $.gulp.series(
    $.gulp.parallel(
        'styles'
    )
));

$.gulp.task('scripts', $.gulp.series(
    $.gulp.parallel(
        'scripts:site',
        'scripts:gutenberg',
        'scripts:authors',
    )
));

$.gulp.task('imgs', $.gulp.series(
    $.gulp.parallel(
        'imgs'
    )
));