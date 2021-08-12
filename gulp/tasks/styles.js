const autoPrefixer = require("gulp-autoprefixer");
let plumber = require("gulp-plumber"),
  concat = require("gulp-concat-css"),
  prefix = require("gulp-autoprefixer"),
  sass = require("gulp-sass"),
  sourcemaps = require("gulp-sourcemaps"),
  minifyCSS = require("gulp-minify-css");

stylesPATH = {
  input: ["./themes/muzyka21/src/css/main.scss","./themes/muzyka21/src/css/*.scss"],
  output: "./themes/muzyka21/css/",
};

module.exports = function () {
//   $.gulp.task('styles', () => {
//       return $.gulp.src(stylesPATH.input)
//       //.pipe(sourcemaps.init())

//       .pipe(scss({ outputStyle: 'compressed'}))
//       .pipe(prefix("last 2 versions"))
//       .pipe(csscomb())
//       .pipe(csso())
//       //.pipe(concat('main.css'))
//       //.pipe(minifyCSS())
//       //.pipe(prefix('last 2 versions'))
//       .pipe(rename('main.css'))
//       .pipe($.gulp.dest(stylesPATH.output))
//   });

  // SCSS Version
  $.gulp.task("styles", () => {
    return $.gulp
      .src(stylesPATH.input)
      .pipe(sourcemaps.init())
      .pipe(sass().on('error', sass.logError))
      .pipe(prefix("last 2 versions"))
      .pipe(sourcemaps.write())
      .pipe(concat("main.css"))
      .pipe(minifyCSS())
      .pipe($.gulp.dest(stylesPATH.output))
      .on('end', $.browserSync.reload);
  });
};
