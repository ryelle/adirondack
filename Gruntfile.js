/* jshint node:true */
module.exports = function(grunt) {
	var path = require('path'),
		THEME_NAME = 'adirondack',
		SOURCE_DIR = 'src/',
		BUILD_DIR = 'build/';

	// Load tasks.
	require('matchdep').filterDev('grunt-*').forEach( grunt.loadNpmTasks );

	// Project configuration.
	grunt.initConfig({
		clean: {
			all: [BUILD_DIR],
			dist: {
				dot: true,
				expand: true,
				cwd: BUILD_DIR,
				src: [
					'node_modules',
					'sass',
					'layouts',
					'.sass-cache'
				]
			},
			dev: [
				SOURCE_DIR + 'style.css',
				SOURCE_DIR + 'rtl.css',
				SOURCE_DIR + 'editor-style.css',
				SOURCE_DIR + 'js/' + THEME_NAME + '.js',
				SOURCE_DIR + 'images/sprite.svg'
			]
		},

		copy: {
			all: {
				files: [{
					dot: true,
					expand: true,
					cwd: SOURCE_DIR,
					src: [
						'**',
						'!**/.{svn,git}/**', // Ignore version control directories.
						'!.DS_Store',
						'!package.json',
						'!Gruntfile.js',
						'!node_modules',
						'!.sass-cache',
						'!.gitignore',
						'!js/src',
						'!images/src'
					],
					dest: BUILD_DIR
				}]
			}
		},

		sass: {
			dev: {
				options: {
					style: 'expanded',
					noCache: false,
					sourcemap: false
				},
				expand: true,
				cwd: SOURCE_DIR + 'sass/',
				dest: SOURCE_DIR,
				ext: '.css',
				src: [ 'style.scss', 'editor-style.scss', 'rtl.scss' ]
			},
			dist: {
				options: {
					style: 'expanded',
					noCache: true,
					sourcemap: false
				},
				expand: true,
				cwd: SOURCE_DIR + 'sass/',
				dest: BUILD_DIR,
				ext: '.css',
				src: [ 'style.scss', 'editor-style.scss', 'rtl.scss' ]
			}
		},

		autoprefixer: {
			options: {},
			dev: {
				src: [ SOURCE_DIR + 'style.css', SOURCE_DIR + 'editor-style.css', SOURCE_DIR + 'rtl.css' ]
			},
			dist: {
				src: [ BUILD_DIR + 'style.css', BUILD_DIR + 'editor-style.css', BUILD_DIR + 'rtl.css' ]
			}
		},

		concat: {
			dev: {
				src: [ SOURCE_DIR + 'js/src/*.js' ],
				dest: SOURCE_DIR + 'js/' + THEME_NAME + '.js',
			},
			dist: {
				src: [ SOURCE_DIR + 'js/src/*.js' ],
				dest: BUILD_DIR + 'js/' + THEME_NAME + '.js',
			}
		},

		svgstore: {
			options: {
				prefix : 'icon-',
				cleanup: true,
				includedemo: false,
				svg: {
					viewBox : '0 0 0 0'
				},
				symbol: {
					fill: 'white'
				}
			},
			dev: {
				src: [SOURCE_DIR + 'images/src/*.svg', '!' + SOURCE_DIR + 'images/src/_*.svg'],
				dest: SOURCE_DIR + 'images/sprite.svg'
			},
			dist: {
				src: [SOURCE_DIR + 'images/src/*.svg', '!' + SOURCE_DIR + 'images/src/_*.svg'],
				dest: BUILD_DIR + 'images/sprite.svg'
			},
		},

		makepot: {
			dev: {
				options: {
					cwd: SOURCE_DIR,
					domainPath: '/languages',
					mainFile: 'style.css',
					potFilename: THEME_NAME + '.pot',
					potHeaders: {
						poedit: true,
						'x-poedit-keywordslist': true,
						'report-msgid-bugs-to': 'http://wordpress.org/support/theme/' + THEME_NAME
					},
					type: 'wp-theme',
					updateTimestamp: false
				}
			},
			dist: {
				options: {
					cwd: BUILD_DIR,
					domainPath: '/languages',
					mainFile: 'style.css',
					potFilename: THEME_NAME + '.pot',
					potHeaders: {
						poedit: true,
						'x-poedit-keywordslist': true,
						'report-msgid-bugs-to': 'http://wordpress.org/support/theme/' + THEME_NAME
					},
					type: 'wp-theme',
					updateTimestamp: false
				}
			}
		},

		compress: {
			main: {
				options: {
					archive: THEME_NAME + '.zip'
				},
				files: [
					{expand: true, cwd: BUILD_DIR, src: ['**'], dest: '/'}
				]
			}
		},

		watch: {
			css: {
				files: [SOURCE_DIR + 'sass/**'],
				tasks: ['sass:dev','autoprefixer:dev']
			},
			js: {
				files: [SOURCE_DIR + 'js/src/**'],
				tasks: ['concat:dev']
			},
			svg: {
				files: [SOURCE_DIR + 'images/src/**'],
				tasks: ['svgstore:dev']
			}
		}
	});

	// Register tasks.

	// Build task.
	grunt.registerTask('dev',     ['sass:dev', 'autoprefixer:dev', 'concat:dev', 'svgstore:dev', 'makepot:dev']);
	grunt.registerTask('build',   ['clean:all', 'copy:all', 'sass:dist', 'autoprefixer:dist', 'concat:dist', 'svgstore:dist', 'makepot:dist', 'clean:dist']);
	grunt.registerTask('zip', ['compress:main']);
	grunt.registerTask('publish', ['build', 'zip']);

	// Default task.
	grunt.registerTask('default', ['dev']);

};
