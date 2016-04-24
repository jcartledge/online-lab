const gulp = require('gulp');
const gulpUtil = require('gulp-util');
const ftp = require('vinyl-ftp');

gulp.task('stage', function () {
  const conn = ftp.create(Object.assign(
    {log: gulpUtil.log},
    require('./ftp.json')['stage']
  ));

  const dest = '.';
  return gulp.src('**', { base: 'wordpress', cwd: 'wordpress', buffer: false })
    .pipe(conn.newer(dest)) // only upload newer files
    .pipe(conn.dest(dest));
});
