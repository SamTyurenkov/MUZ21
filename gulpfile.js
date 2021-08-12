"use strict";

global.$ = {
    path: {
        task: require('./gulp/path/tasks.js')
    },
    gulp: require('gulp'),
    browserSync: require('browser-sync').create(),
    del: require('del')
};

$.path.task.forEach(function (taskPath) {
    require(taskPath)();
});

$.gulp.task('default', $.gulp.series(
//    'clean',
    $.gulp.parallel(
        'styles',
        'scripts:site',
        'scripts:gutenberg',
        'scripts:login-reg',
        'scripts:author-page',
        'scripts:admin-stuff',
        'scripts:libs',
        'imgs',
        'watch',
        'browser-sync'
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
        'scripts:login-reg',
        'scripts:author-page',
        'scripts:admin-stuff',
        'scripts:libs',
    )
));

$.gulp.task('imgs', $.gulp.series(
    $.gulp.parallel(
        'imgs'
    )
));