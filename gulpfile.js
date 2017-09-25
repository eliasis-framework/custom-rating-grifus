/**
 * Custom Rating Grifus · Extensions For Grifus
 * 
 * @author     Josantonius - hello@josantonius.com
 * @copyright  Copyright (c) 2017
 * @license    GPL-2.0+
 * @link       https://github.com/Josantonius/Custom-Rating-Grifus.git
 * @since      1.0.5
 */

// Dependencies

var gulp         = require('gulp'),
  	concat       = require('gulp-concat'),
  	uglify       = require('gulp-uglify'),
  	sass         = require('gulp-sass'),
  	plumber      = require('gulp-plumber'),
  	rename       = require('gulp-rename'),
  	cleanCSS     = require('gulp-clean-css'),
  	notify       = require('gulp-notify'),
  	sourcemaps   = require('gulp-sourcemaps'),
  	autoprefixer = require('gulp-autoprefixer');

// Tasks

gulp.task('js', function () {

    var files = [
    		'public/js/source/custom-rating-grifus.js',
    		'public/js/source/custom-rating-grifus-admin.js',
    		'public/js/source/custom-rating-grifus-edit-post.js',
    		'public/js/source/custom-rating-grifus-home.js'
    	],

        min  = [
        	'custom-rating-grifus.min.js',
        	'custom-rating-grifus-admin.min.js',
        	'custom-rating-grifus-edit-post.min.js',
        	'custom-rating-grifus-home.min.js'
        ],

        dest = 'public/js/',

        notifyOptions = { 

            message: 'Scripts task complete' 
        };

    gulp.src(files[0])
        .pipe(concat(min[0]))
        .pipe(uglify())
        .pipe(gulp.dest(dest));

    gulp.src(files[1])
        .pipe(concat(min[1]))
        .pipe(uglify())
        .pipe(gulp.dest(dest));

    gulp.src(files[2])
        .pipe(concat(min[2]))
        .pipe(uglify())
        .pipe(gulp.dest(dest));

    gulp.src(files[3])
        .pipe(concat(min[3]))
        .pipe(uglify())
        .pipe(gulp.dest(dest))
        .pipe(notify(notifyOptions));

});

gulp.task('css', function () {

	var main   = [
			'public/sass/admin/custom-rating-grifus-admin.sass',
			'public/sass/admin/custom-rating-grifus-edit-post.sass',
			'public/sass/front/custom-rating-grifus.sass'
		],

		source = 'public/css/source/',
		dest   = 'public/css/',

		sourcemapsOption = { 

		  	content: { 

		  		includeContent: false 
		  	}, 

		  	init: {

		  		loadMaps: true 
		  	} 
		},

		sassOptions = {

			errLogToConsole: true, 
			outputStyle:     'expanded' 
		},

		autoprefixerOptions = { 

			browsers: ['last 2 versions'], 
			cascade:  true 
		},

		notifyOptions = {

			message: 'Styles task complete'
		},

		cssOptions = {

			compatibility: 'ie8' 
		};

		renameOptions = {

			suffix: '.min'
		};

	gulp.src(main[0])
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass(sassOptions).on('error', sass.logError))
		.pipe(sourcemaps.write(sourcemapsOption.content))
		.pipe(sourcemaps.init(sourcemapsOption.init))
		.pipe(autoprefixer(autoprefixerOptions))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(source))
		.pipe(rename(renameOptions))
		.pipe(cleanCSS(cssOptions))
		.pipe(gulp.dest(dest))
		.pipe(notify(notifyOptions));

	gulp.src(main[1])
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass(sassOptions).on('error', sass.logError))
		.pipe(sourcemaps.write(sourcemapsOption.content))
		.pipe(sourcemaps.init(sourcemapsOption.init))
		.pipe(autoprefixer(autoprefixerOptions))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(source))
		.pipe(rename(renameOptions))
		.pipe(cleanCSS(cssOptions))
		.pipe(gulp.dest(dest))
		.pipe(notify(notifyOptions));

	gulp.src(main[2])
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(sass(sassOptions).on('error', sass.logError))
		.pipe(sourcemaps.write(sourcemapsOption.content))
		.pipe(sourcemaps.init(sourcemapsOption.init))
		.pipe(autoprefixer(autoprefixerOptions))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest(source))
		.pipe(rename(renameOptions))
		.pipe(cleanCSS(cssOptions))
		.pipe(gulp.dest(dest))
		.pipe(notify(notifyOptions));

});

gulp.task('watch', function () {

	var sassFiles = [
			'public/sass/front/**/*.sass',
			'public/sass/admin/**/*.sass',
			'public/sass/front/custom-rating-grifus.sass',
			'public/sass/admin/custom-rating-grifus-admin.sass',
			'public/sass/admin/custom-rating-grifus-edit-post.sass'
		],

		jsFiles  = 'public/js/source/*.js';

	gulp.watch(jsFiles, ['js']);

	gulp.watch(sassFiles, ['css']);

});

gulp.task('default', ['js', 'css']);
