let uglify = require("gulp-terser"),
  concat = require("gulp-concat"),
  scriptsPATH = {
    input: "./themes/asp/src/js/",
    output: "./themes/asp/js/",
  };
var babel = require("gulp-babel");
var browserify = require("gulp-browserify");
const include = require("gulp-include");

module.exports = function () {
  $.gulp.task("scripts:site", () => {
    return $.gulp
      .src([
        "./node_modules/@splidejs/splide/dist/js/splide.min.js",
        scriptsPATH.input + "w3schools-select.js",
        scriptsPATH.input + "*.js",
        "!" + scriptsPATH.input + "gutenberg-blocks/*.js",
        "!" + scriptsPATH.input + "authors/*.js",
      ])
      .pipe(concat("main.js"))
      .pipe(include())
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
      .pipe(include())
      .pipe($.gulp.dest(scriptsPATH.output + "gutenberg-blocks/"));
  });
  $.gulp.task("scripts:authors", () => {
    return $.gulp
      .src([scriptsPATH.input + "authors/*.js"])
      .pipe(concat("authors.js"))
      .pipe(include())
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
};
