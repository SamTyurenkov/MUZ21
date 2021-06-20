let uglify = require("gulp-terser"),
  gulpif = require("gulp-if"),
  concat = require("gulp-concat"),
  scriptsPATH = {
    input: "./themes/muzyka21/src/js/",
    output: "./themes/muzyka21/js/",
  };
var babel = require("gulp-babel");

module.exports = function () {
  $.gulp.task("scripts:site", () => {
    return $.gulp
      .src([
        scriptsPATH.input + "errors_manager.js",
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
      .pipe(
        babel({
          presets: ["@babel/preset-env","@babel/preset-react"],
          plugins: [
            [
              "@babel/plugin-proposal-class-properties"
            ]
          ]
        })
      )
      .pipe($.gulp.dest(scriptsPATH.output + "gutenberg-blocks/"));
  });
  $.gulp.task("scripts:login-reg", () => {
    return $.gulp
      .src([scriptsPATH.input + "login-reg/*.js"])
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
      .pipe($.gulp.dest(scriptsPATH.output+ "login-reg/"));
  });
  $.gulp.task("scripts:libs", () => {
    return $.gulp
      .src(["./node_modules/@splidejs/splide/dist/js/splide.min.js",scriptsPATH.input + "situational/*.js"])
      .pipe($.gulp.dest(scriptsPATH.output));
  });
};
