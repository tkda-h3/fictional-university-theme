const gulp = require('gulp');

const config = require('../config');


gulp.task('css:wp:declare', function(done){
    gulp.src(config.src.css + '/style.css')
    .pipe(gulp.dest(config.wp.dist + '/'));

    gulp.src([config.src.css + '/**/*.css' , '!' + config.src.css + '/style.css'])
    .pipe(gulp.dest(config.wp.dist + '/css/'));

    done();
});
