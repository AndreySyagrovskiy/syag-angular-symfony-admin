var gulp = require('gulp');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglifyjs');
var uglifycss = require('gulp-uglifycss');

gulp.task('js', function() {
    return gulp.src([
            'js/source/app.modules.js',
            'js/source/page.entity.js',
            'js/source/has_permission.js',
            'js/source/authorization/authorization.module.js',
            'js/source/authorization/authorization.service.js',
            'js/source/authorization/http_error_processor.config.js',
            //'js/source/authorization/authorization.router.js',
            'js/source/authorization/login.controller.js',
        ])
        .pipe(sourcemaps.init())
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest('js/dist'));
});

gulp.task('libjs', function() {
    return gulp.src([
            'bower_components/ng-admin/build/ng-admin.min.js'
        ])
        .pipe(concat('lib.js'))
        .pipe(gulp.dest('js/dist'))
    ;
});


var sass = require('gulp-sass');
gulp.task('styles', function () {
    gulp.src('scss/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(uglifycss())
        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest('css/dist'));
});



gulp.task('default', ['js', 'libjs', 'styles']);

//Watch task
gulp.task('watch', ['default'], function () {
    gulp.watch('scss/**/*.scss', ['styles']);
    gulp.watch('js/source/**/*.js', ['js']);
});