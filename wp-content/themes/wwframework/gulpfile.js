'use strict';

const gulp = require('gulp'),                       // https://www.npmjs.com/package/gulp
    util = require('gulp-util'),                    // https://www.npmjs.com/package/gulp-util
    // rename = require("gulp-rename"),             // https://www.npmjs.com/package/gulp-rename
    concat = require('gulp-concat'),                // https://www.npmjs.com/package/gulp-concat
    sass = require('gulp-sass'),                    // https://www.npmjs.com/package/gulp-sass
    sassGlob = require('gulp-sass-glob'),           // https://www.npmjs.com/package/gulp-sass-glob
    del = require('del'),                           // https://www.npmjs.com/package/del
    sourcemaps = require('gulp-sourcemaps'),        // https://www.npmjs.com/package/gulp-sourcemaps
    autoprefixer = require('gulp-autoprefixer'),    // https://www.npmjs.com/package/gulp-autoprefixer
    // uglifyjs = require('gulp-uglify'),           // https://www.npmjs.com/package/gulp-uglify
    // uglifycss = require('gulp-uglifycss'),       // https://www.npmjs.com/package/gulp-uglifycss
    livereload = require('gulp-livereload'),        // https://www.npmjs.com/package/gulp-livereload
    filter = require('gulp-filter'),                // https://www.npmjs.com/package/gulp-filter
    bower = require('gulp-bower'),                  // https://www.npmjs.com/package/gulp-bower
    // bowerFiles = require('main-bower-files'),    // https://www.npmjs.com/package/main-bower-files
    // ngAnnotate = require('gulp-ng-annotate'),    // https://www.npmjs.com/package/gulp-ng-annotate
    imagemin = require("gulp-imagemin"),            // https://www.npmjs.com/package/gulp-imagemin
    imageminGuetzli = require("imagemin-guetzli"),  // https://www.npmjs.com/package/imagemin-guetzli
    phpLint = require("gulp-phplint"),              // https://www.npmjs.com/package/gulp-phplint
    jsLint = require("gulp-jshint"),                // https://www.npmjs.com/package/gulp-jshint
    sassLint = require("gulp-sass-lint"),           // https://www.npmjs.com/package/gulp-sass-lint
    notify = require("gulp-notify");                // https://www.npmjs.com/package/gulp-notify
/*
 * Enable production by passing --production to the gulp command
 *
 * Example: `gulp build --production`
 *
 * Example usage in pipe: .pipe(production ? uglifycss() : util.noop())
 */
var production = !!util.env.production;

// NOTE: Use Autoptimize plugin for CSS/JS minification, optimization, and aggregation! No need to worry about this in gulpfile

/** Begin Bower **/

// Delete libraries pulled from bower.json
// WARNING: if any of these local bower libraries were altered (added, deleted, edited anything) and you need to keep edits, DO NOT RUN
gulp.task('clean-bower', function () {
    return del.sync('libs/bower_libs');
});

// Pull libraries into libraries/bower using bower.json
gulp.task('bower-install', function () {
    return bower();
});

gulp.task('bower-update', function () {
    return bower({cmd: 'update'});
});

// Reinstall bower libraries by removing and recreating libraries/bower directory
// WARNING: if any of these local bower libraries were altered (added, deleted, edited anything) and you need to keep edits, DO NOT RUN
gulp.task('bower-reinstall', ['clean-bower'], function () {
    return gulp.start('bower-install');
});

/** End Bower **/

/** Begin Images **/
gulp.task('optimize-jpgs', function () {
    return gulp.src(['images/**/*.{jpg, jpeg}'])
        .pipe(imagemin([imageminGuetzli()]))
        .pipe(gulp.dest('images'))
        .pipe(notify({message: 'Compress jpgs task complete'}));
});

gulp.task('optimize-non-jpgs', function () {
    return gulp.src(['images/**', '!images/**/*.{jpg, jpeg}'])
        .pipe(imagemin({
            optimizationLevel: 7,
            progressive: true,
            interlaced: true
        }))
        .pipe(gulp.dest('images'))
        .pipe(notify({message: 'Compress non-jpgs task complete'}));
});

gulp.task('optimize-images', ['optimize-jpgs', 'optimize-non-jpgs']);

/** End Images **/

/** Begin JS **/

gulp.task('js-lint', function () {
    return gulp.src(['js/**/*.js', '!js/**/*.min.js'])
        .pipe(jsLint())
        .pipe(jsLint.reporter('default'));
});

/** End JS **/

/** Begin CSS **/

gulp.task('clean-css', function () {
    return del([
        // '!keep_this_file.txt', // A way of excluding some files from being deleted after a pattern-match
        'style.css',
        'style.css.map'
    ], {
        force: true
    });
});


// Build everything in the sass directory
gulp.task('build-sass', function () {
    return gulp.src(['sass/style.scss'])
        .pipe(sourcemaps.init())
        .pipe(sassGlob())
        .pipe(sass().on('error', notify.onError('<%= error.message %>')))
        .pipe(autoprefixer({
            browsers: ['ios >= 8', 'last 2 versions']
        }))
        .pipe(sourcemaps.write('.')) // write to same directory where CSS will live (allows for the proper reference to Sourcemap in CSS file!)
        .pipe(gulp.dest('.'))
        .pipe(filter('style.css')) // isolate to css file alone - otherwise, livereload will do a full reload of the page b/c it's accounting for a non-css file (*.css.map)
        .pipe(livereload());
});

gulp.task('sass-lint', function () {
    return gulp.src(['sass/**/*.s+(a|c)ss'])
        .pipe(sassLint({configFile: 'sass-lint.yml'}))
        .pipe(sassLint.format())
        .pipe(sassLint.failOnError());
});

/** End CSS **/

/** Begin PHP **/

gulp.task('php-lint', function () {
    return gulp.src(['./**/*.php'])
        .pipe(phpLint());
});

/** End PHP **/

/** Begin Simplified Tasks **/

// Clean Bower and generated CSS
gulp.task('clean', ['clean-bower', 'clean-css']);

gulp.task('build-css', ['build-sass']);

gulp.task('build', ['bower-install', 'optimize-images'], function () {
    return gulp.start('build-css');
}); // Add build-js, any other build processes down the road

/** End Simplified Tasks **/

/** Begin Watch/Default Tasks **/

// watch sass files, js, and templates
gulp.task('watch', ['build'], function () {
    livereload.listen();

    gulp.watch('sass/**/*.scss', ['build-css']);

    // Watch JS and PHP template files
    gulp.watch([
        'js/**/*.js'
    ]).on('change', function (file) {
        livereload.changed(file.path); // Optional: do a full reload if changed
        util.log(util.colors.yellow('Javascript changed' + ' (' + file.path + ')'));
    });

    gulp.watch([
        '*.php',
        'template-parts/*.php',
        'template-parts/panels/*.php',
        'functions/**/*.php'
    ]).on('change', function (file) {
        livereload.changed(file.path); // Optional: do a full reload if changed
        util.log(util.colors.yellow('Template changed' + ' (' + file.path + ')'));
    });
});

gulp.task('default', ['clean', 'watch']);

/** End Watch/Default Tasks **/
