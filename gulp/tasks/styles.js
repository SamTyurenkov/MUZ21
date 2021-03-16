let plumber = require('gulp-plumber'),
    concat = require('gulp-concat-css'),
    prefix = require('gulp-autoprefixer'),
    minifyCSS = require('gulp-minify-css');

stylesPATH = {
    "input": ["./themes/asp/src/css/**/*.css","node_modules/@splidejs/splide/dist/css/splide-core.min.css"],
    "output": "./themes/asp/css/"
}

module.exports = function () {
    $.gulp.task('styles', () => {
        return $.gulp.src(stylesPATH.input)
        .pipe(concat('main.css'))
        .pipe(minifyCSS())
        .pipe(prefix('last 3 versions'))
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