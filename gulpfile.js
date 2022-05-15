var gulp    	= 	require('gulp'), // Gulp
	zip			=	require('gulp-zip'), // Zip
	babel		= 	require('gulp-babel'), // Babel
	uglify  	= 	require('gulp-uglify'), // Minify
	concat  	= 	require('gulp-concat'), // Concate
	plumber 	= 	require('gulp-plumber'), // Lint the code
	sass		=	require('gulp-sass')(require('sass')) // Sass
 
// Minify e concate scripts
gulp.task('js-compiler', e => {
	return gulp.src([
		'assets/js/scripts/**/*.js'
	])
	.pipe(plumber())
	.pipe(babel({
		compact: false,
		comments: false,
		presets: [ '@babel/env' ],
	}))
	.pipe(concat('index.js'))
	.pipe(uglify())
	.pipe(gulp.dest('assets/js'))
})
 
// Minify e concate scripts
gulp.task('js-backslash-compiler', e => {
	return gulp.src([
		'assets/js/backslash/**/*.js'
	])
	.pipe(plumber())
	.pipe(babel({
		compact: false,
		comments: false,
		presets: [ '@babel/env' ],
	}))
	.pipe(concat('backslash.js'))
	.pipe(uglify())
	.pipe(gulp.dest('assets/js'))
})

// Compile the sass file's
gulp.task('sass-compiler', e => {
	return gulp.src('assets/sass/**/*.{scss, sass}')
		.pipe(
			sass.sync({
				outputStyle: 'compressed'
			}).on('error', sass.logError)
		)
		.pipe(gulp.dest('assets/css'))
})

// Watch the js files
gulp.task('js', e => {
	gulp.watch([
		'assets/js/scripts/**/*.js'
	], gulp.parallel([
		'js-compiler'
	]))
})

// Watch the sass files
gulp.task('sass', e => {
	gulp.watch([
		'assets/sass/**/*.scss'
	], gulp.parallel([
		'sass-compiler'
	]))
})

// Package the project for upload to web
gulp.task('package', e => {
	return gulp.src([
		'**/assets/**',
		'!**/assets/sass/**',
		'!**/node_modules/**',
		'!**/assets/php/**/*.md',
		'!**/assets/js/bundle/**',
		'!**/assets/js/scripts/**',
		'!**/assets/php/**/composer.json',
		'!**/*.lock',
		'!**/logs/*.json',
		'!**/package.json',
		'!/test.php',
		'**/*.php',
		'.htaccess',
		'robots.txt',
	])
	.pipe(zip('website.zip'))
	.pipe(gulp.dest('./'))
})