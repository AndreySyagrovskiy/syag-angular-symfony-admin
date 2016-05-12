var gulp = require('gulp');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');


gulp.task('join-js', function() {
    return gulp.src([
            'bower_components/jquery/jquery.min.js',
            'bower_components/jquery-validation/dist/jquery.validate.min.js',
            'js/source/login.js',
        ])
        .pipe(sourcemaps.init())
        .pipe(concat('main.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('js/dev'));
});


var sass = require('gulp-sass');
gulp.task('styles', function () {
    gulp.src('scss/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('css/dev'));
});


var uglify = require('gulp-uglifyjs');
gulp.task('compressjs', function() {
    gulp.src('js/dev/main.js')
        .pipe(uglify())
        .pipe(gulp.dest('js/dist'))
});


var uglifycss = require('gulp-uglifycss');
gulp.task('compresscss', function () {
    gulp.src('css/dev/style.css')
        .pipe(uglifycss())
        .pipe(gulp.dest('css/dist'));
});

var rev = require('gulp-rev-append');

/*gulp.task('rev', function() {
    gulp.src('./template/index.html')
        .pipe(rev())
        .pipe(gulp.dest('.'));
});*/


//Watch task
gulp.task('default', function () {
    gulp.watch('scss/**/*.scss', ['styles']);
    gulp.watch('js/source/**/*.js', ['join-js']);

    gulp.watch('css/dev/style.css', ['compresscss']);
    gulp.watch('js/dev/main.js', ['compressjs']);
});