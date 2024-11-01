var gulp = require('gulp');
var concat = require('gulp-concat');

var taskListing = require('gulp-task-listing');
gulp.task('help', taskListing);

var size = require('gulp-size');

var rename = require('gulp-rename');
var strip = require('gulp-strip-comments');

gulp.task('js', function () {

    return gulp.src('./src/js/*.js')
        .pipe(strip())
        .pipe(concat('app.js'))
        .pipe(size())
        // .pipe(compressor())
        .pipe(gulp.dest('./assets/js/'));

});

gulp.task('watch', function() {
    gulp.watch('./src/js/*.js', ['js']);
});

// Default Task
gulp.task('default', ['js', 'watch']);