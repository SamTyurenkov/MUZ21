const autoPrefixer = require("gulp-autoprefixer"),
  plumber = require("gulp-plumber"),
  concat = require("gulp-concat-css"),
  prefix = require("gulp-autoprefixer"),
  sass = require('gulp-sass')(require('sass')),
  sourcemaps = require("gulp-sourcemaps"),
  minifyCSS = require("gulp-csso");

stylesPATH = {
  input: ["./themes/muzyka21/src/css/main.scss","./themes/muzyka21/src/css/*.scss"],
  output: "./themes/muzyka21/css/",
};

module.exports = function () {

  // SCSS Version
  $.gulp.task("styles", () => {
    return $.gulp
      .src(stylesPATH.input)
      .pipe(sourcemaps.init())
      .pipe(plumber())
      .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
      .pipe(concat("main.css"))
      .pipe(prefix("last 2 versions"))
      .pipe(minifyCSS())
      .pipe(sourcemaps.write('.'))
      .pipe($.gulp.dest(stylesPATH.output))
      .pipe($.browserSync.stream());
      //.on('end',$.browserSync.reload);
  });
};
