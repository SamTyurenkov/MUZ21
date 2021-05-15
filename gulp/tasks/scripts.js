let uglify = require("gulp-terser"),
  gulpif = require("gulp-if"),
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
        scriptsPATH.input + "errors_manager.js",
        scriptsPATH.input + "metrika.min.js",
        scriptsPATH.input + "w3schools-select.js",
        scriptsPATH.input + "*.js",
        "!" + scriptsPATH.input + "property/*.js",
       // "!" + scriptsPATH.input + "gutenberg-blocks/*.js",
        "!" + scriptsPATH.input + "authors/*.js",
      ])
      .pipe(gulpif('!**/*.min.js', uglify({mangle: false})))
      .pipe(concat("main.js"))
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
  $.gulp.task("scripts:property", () => {
    return $.gulp
      .src([scriptsPATH.input + "property/*.js"])
      .pipe(concat("property.js"))
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
      .src(["./node_modules/@splidejs/splide/dist/js/splide.min.js",scriptsPATH.input + "situational/*.js"])
      .pipe($.gulp.dest(scriptsPATH.output));
  });
};
