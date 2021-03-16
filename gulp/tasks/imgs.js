let imagemin = require('gulp-imagemin'),
imageminJpegRecompress = require('imagemin-jpeg-recompress'),
pngquant = require('imagemin-pngquant'),
cache = require('gulp-cache'),
rimraf = require('rimraf'),

imgPATH = {
    "input": ["./themes/asp/src/images/**/*.{png,jpg,gif,svg,jpeg}"],
    "output": "./themes/asp/images/"
}

module.exports = function() {
    $.gulp.task('imgs', () => {
        return $.gulp.src(imgPATH.input)
        .pipe(imagemin([
            imagemin.gifsicle({
                interlaced: true
            }),
            imagemin.jpegtran({
                progressive: true
            }),
            imageminJpegRecompress({
                loops: 4,
                min: 90,
                max: 95,
                quality: 'high'
            }),
            imagemin.optipng({
                optimizationLevel: 3
            }),
            pngquant({
                quality: '100',
                speed: 5
            })
        ], {
            verbose: true
        }))
        .pipe($.gulp.dest(imgPATH.output));
    });
};
