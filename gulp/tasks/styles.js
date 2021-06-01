let plumber = require('gulp-plumber'),
    concat = require('gulp-concat-css'),
    prefix = require('gulp-autoprefixer'),
    minifyCSS = require('gulp-minify-css');

stylesPATH = {
    "input": ["./themes/muzika21/src/css/**/*.css","node_modules/@splidejs/splide/dist/css/splide-core.min.css"],
    "output": "./themes/muzika21/css/"
}

module.exports = function () {
    $.gulp.task('styles', () => {
        return $.gulp.src(stylesPATH.input)
        .pipe(concat('main.css'))
        .pipe(minifyCSS())
        .pipe(prefix('last 2 versions'))
        .pipe($.gulp.dest(stylesPATH.output))
    });

    // SCSS Version
//$.gulp.task('styles', function(){
    //return $.gulp.src('src/scss/**/*.scss')
    //.pipe(sass())
    //.pipe(prefix('last 3 versions'))
    //.pipe(concat('main.css'))
    //.pipe(minifyCSS())
    //.pipe($.gulp.dest('stylesPATH.output'))
//});
}