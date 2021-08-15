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
        scriptsPATH.input + "anime.min.js",
        scriptsPATH.input + "errors_manager.js",
        scriptsPATH.input + "w3schools-select.js",
        scriptsPATH.input + "*.js",
        "!" + scriptsPATH.input + "admin-stuff/*.js",
        "!" + scriptsPATH.input + "login-reg/*.js",
        "!" + scriptsPATH.input + "gutenberg-blocks/*.js",
        "!" + scriptsPATH.input + "author_page/*.js",
      ])
      .pipe(gulpif('!**/*.min.js', uglify({mangle: false})))
      .pipe(concat("main.js"))
      .pipe($.gulp.dest(scriptsPATH.output))
      .pipe($.browserSync.stream());
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
      .pipe($.gulp.dest(scriptsPATH.output + "gutenberg-blocks/"))
      .pipe($.browserSync.stream());
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
      .pipe($.gulp.dest(scriptsPATH.output+ "login-reg/"))
      .pipe($.browserSync.stream());
  });
  $.gulp.task("scripts:author-page", () => {
    return $.gulp
      .src([scriptsPATH.input + "author-page/*.js"])
      .pipe(gulpif('!**/*.min.js',
        uglify({
          keep_fnames: true,
          mangle: false,
        }))
      )
      .pipe(concat("author_page.js"))
      .pipe($.gulp.dest(scriptsPATH.output+ "author-page/"))
      .pipe($.browserSync.stream());
  });
  $.gulp.task("scripts:admin-stuff", () => {
    return $.gulp
      .src([scriptsPATH.input + "admin-stuff/*.js"])
      .pipe(gulpif('!**/*.min.js',
        uglify({
          keep_fnames: true,
          mangle: false,
        }))
      )
      //.pipe(concat("admin-author.js"))
      .pipe($.gulp.dest(scriptsPATH.output+ "admin-stuff/"))
      .pipe($.browserSync.stream());
  });
  $.gulp.task("scripts:libs", () => {
    return $.gulp
      .src(["./node_modules/@splidejs/splide/dist/js/splide.min.js",scriptsPATH.input + "situational/*.js"])
      .pipe($.gulp.dest(scriptsPATH.output))
      .pipe($.browserSync.stream());
  });
};
