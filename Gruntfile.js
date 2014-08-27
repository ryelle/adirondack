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
					'README.md',
					'layouts',
					'.sass-cache'
				]
			}
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
						'!js/src'
					],
					dest: BUILD_DIR
				}]
			}
		},

		sass: {
			dev: {
				options: {
					noCache: false,
					sourcemap: true
				},
				expand: true,
				cwd: SOURCE_DIR + 'sass/',
				dest: SOURCE_DIR,
				ext: '.css',
				src: [ 'style.scss', 'editor-style.scss' ]
			},
			dist: {
				options: {
					noCache: true,
					sourcemap: false
				},
				expand: true,
				cwd: SOURCE_DIR + 'sass/',
				dest: BUILD_DIR,
				ext: '.css',
				src: [ 'style.scss', 'editor-style.scss' ]
			}
		},

		autoprefixer: {
			options: {},
			dev: {
				src: SOURCE_DIR + 'style.css'
			},
			dist: {
				src: BUILD_DIR + 'style.css'
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

		pageres: {
			dist: {
				options: {
					url: 'trunk.wordpress.dev',
					sizes: ['320x480', '320x568', '768x1024'],
					delay: '3',
					dest: 'screenshots'
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
				tasks: ['sass:dev']
			},
			js: {
				files: [SOURCE_DIR + 'js/src/**'],
				tasks: ['concat:dev']
			}
		}
	});

	// Register tasks.

	// Build task.
	grunt.registerTask('dev',     ['sass:dev', 'autoprefixer:dev', 'concat:dev']);
	grunt.registerTask('build',   ['clean:all', 'copy:all', 'sass:dist', 'autoprefixer:dist', 'concat:dist', 'clean:dist']);
	grunt.registerTask('publish', ['build', 'compress:main']);

	grunt.registerTask('screenshot', ['pageres']);

	// Default task.
	grunt.registerTask('default', ['dev']);

};
