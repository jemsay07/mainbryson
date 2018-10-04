var gulp = require('gulp');

// CSS related plugins
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

//Project related Variables
//var projectURL = 'http://www.sandbox.practice.com/';
var styleSRC = './src/sass/mainbryson.scss';
var styleURL = './assets/css/';
var mapURL = './';

// Utility plugins
var sourcemaps = require('gulp-sourcemaps');

gulp.task('style', function(){
  gulp.src(styleSRC)
    .pipe(sourcemaps.init())
    .pipe( sass({
      errLogToConsole: true,
      outputStyle: 'compressed'      
    }) )
    .on('error', console.error.bind(console))
    .pipe( autoprefixer({ browsers: ['last 2 versions', '> 5%', 'Firefox ESR'] }) )
    .pipe(sourcemaps.write(mapURL))
    .pipe( gulp.dest( styleURL ) );
});