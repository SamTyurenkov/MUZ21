let uglify = require("gulp-terser"),
  concat = require("gulp-concat"),
  scriptsPATH = {
    input: "./themes/asp/src/js/",
    output: "./themes/asp/js/",
  };
var babel = require("gulp-babel");

module.exports = function () {
  $.gulp.task("scripts:site", () => {
    return $.gulp
      .src([
        scriptsPATH.input + "w3schools-select.js",
        scriptsPATH.input + "*.js",
        "!" + scriptsPATH.input + "gutenberg-blocks/*.js",
        "!" + scriptsPATH.input + "authors/*.js",
      ])
      .pipe(concat("main.js"))
      .pipe(
        uglify({
          keep_fnames: true,
          mangle: false,
        })
      )
      .pipe(
        babel({
          presets: ["@babel/preset-env"],
        })
      )
      .pipe($.gulp.dest(scriptsPATH.output));
  });
  $.gulp.task("scripts:gutenberg", () => {
    return $.gulp
      .src([scriptsPATH.input + "gutenberg-blocks/*.js"])
      .pipe($.gulp.dest(scriptsPATH.output + "gutenberg-blocks/"));
  });
  $.gulp.task("scripts:authors", () => {
    return $.gulp
      .src([scriptsPATH.input + "authors/*.js"])
      .pipe(concat("authors.js"))
      .pipe(
        uglify({
          keep_fnames: true,
          mangle: false,
        })
      )
      .pipe(
        babel({
          presets: ["@babel/preset-env"],
        })
      )
      .pipe($.gulp.dest(scriptsPATH.output));
  });
  $.gulp.task("scripts:libs", () => {
    return $.gulp
      .src(["./node_modules/@splidejs/splide/dist/js/splide.min.js"])
      .pipe($.gulp.dest(scriptsPATH.output));
  });
};
