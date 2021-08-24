const gulp = require('gulp');

const webpackStream = require("webpack-stream");
const webpack = require("webpack");
const webpackConfig = require("../../webpack.config");

const config = require('../config');

gulp.task("webpack", function (done) {
  webpackStream(webpackConfig, webpack)
    .pipe(gulp.dest(config.wp.dist + '/js'));
  setTimeout(done, 5000);
});
