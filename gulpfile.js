const gulp = require('gulp')
const gulpUtil = require('gulp-util')
const ftp = require('vinyl-ftp')

function deploy (target) {
  return function () {
    const conn = ftp.create(Object.assign(
      {log: gulpUtil.log},
      require('./ftp.json')[target]
    ))

    const globs = [
      '**',
      '!**/node_modules/**',
      '!*.log',
      '!wp-config.php',
      '!wp-content/advanced-cache.php',
      '!wp-content/backup-db/',
      '!wp-content/backups/',
      '!wp-content/blogs.dir/',
      '!wp-content/cache/',
      '!wp-content/upgrade/',
      '!wp-content/uploads/',
      '!wp-content/wp-cache-config.php',
      '!wp-content/plugins/hello.php'
    ]

    const dest = '.'
    return gulp.src(globs, { base: 'wordpress', cwd: 'wordpress', buffer: false })
      .pipe(conn.newerOrDifferentSize(dest))
      .pipe(conn.dest(dest))
  }
}

['stage', 'deploy'].map(function (target) {
  gulp.task(target, deploy(target))
})
