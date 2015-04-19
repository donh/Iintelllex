/**
 * Gruntfile
 *
 * If you created your Sails app with `sails new foo --linker`, 
 * the following files will be automatically injected (in order)
 * into the EJS and HTML files in your `views` and `assets` folders.
 *
 * At the top part of this file, you'll find a few of the most commonly
 * configured options, but Sails' integration with Grunt is also fully
 * customizable.	If you'd like to work with your assets differently 
 * you can change this file to do anything you like!
 *
 * More information on using Grunt to work with static assets:
 * http://gruntjs.com/configuring-tasks
 */
'use strict';
module.exports = function (grunt) {
	// show elapsed time at the end
	require('time-grunt')(grunt);
	// load all grunt tasks
	require('load-grunt-tasks')(grunt);

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		itlconfig: {
			www: '/var/www',
			itl: '<%= itlconfig.www %>/intelllex',
			production: '<%= itlconfig.itl %>/production',
			asset: '<%= itlconfig.production %>/public',
			root: '<%= itlconfig.itl %>/php',
			app: '<%= itlconfig.root %>/app',
			webroot: '<%= itlconfig.root %>/public',
			css: '<%= itlconfig.webroot %>/css',
			js: '<%= itlconfig.webroot %>/js',
			templates: '<%= itlconfig.webroot %>/templates',
		},

		phpcs: {
			application: {
				dir: 'app'
				// dir: 'src'
			},
			options: {
				bin: 'phpcs',
				standard: 'PSR-MOD'
			}
		},

		phplint: {
			options: {
				swapPath: '/tmp'
			},
			all: [
				'app/config/*.php', 'app/controllers/*.php', 'app/models/*.php', 'public/index.php'
			]
		}, 

		clean: {
			options: {
				force: true
			},
			dev: ['.tmp/public/**'],
			build: ['www'],
			prod: ['<%= itlconfig.production %>']
		},

		// http://gruntjs.com/sample-gruntfile
		jshint: {
			// define the files to lint
			src: ['public/js/app.js', 'package.json', 'Gruntfile.js'],
			options: {
				// more options here if you want to override JSHint defaults
				//strict: false,
				globalstrict: true,
				laxbreak: true,
				laxcomma: true,
				scripturl: true,
				globals: {
					'imagesLoaded': false,
					'Masonry': false,
					'angular': false,
					'require': false,
					'parent': false,
					'User': false,
					'Subscriber': false,
					'Dress': false,
					'Designer': false,
					'Collection': false,
					'EmailService': false,
					'process': false,
					'exports': false,
					'sails': false,
					'locals': false,
					'document': false,
					'window': false,
					'$': false,
					'alert': false,
					'sessionStorage': false,
					'adsbygoogle': false,
					//scripturl: false,
					jQuery: true,
					console: true,
					module: true
				}
			}
		},

		copy: {
			dev: {
				files: [
					{
						expand: true,
						cwd: './assets',
						src: ['**/*.!(coffee)'],
						dest: '.tmp/public'
					}
				]
			},
			build: {
				files: [
					{
						expand: true,
						cwd: '.tmp/public',
						src: ['**/*'],
						dest: 'www'
					}
				]
			},
			prod: {
				files: [
					// {expand: true, src: ['path/*'], dest: 'dest/', filter: 'isFile'},
					{
						expand: true,
						cwd: 'public/css',
						src: ['*.css'],
						dest: '<%= itlconfig.asset %>/css',
						filter: 'isFile'
					},
					{
						expand: true,
						cwd: 'public/js',
						src: ['*.min.js'],
						dest: '<%= itlconfig.asset %>/js',
						filter: 'isFile'
					},
					{
						expand: true,
						src: ['public/index.php'],
						dest: '<%= itlconfig.production %>'
					},
					{
						expand: true,
						cwd: 'app',
						src: ['config/**'],
						dest: '<%= itlconfig.production %>/app',
						// filter: 'isFile'
					},
					{
						expand: true,
						cwd: 'app',
						src: ['controllers/**'],
						dest: '<%= itlconfig.production %>/app',
						filter: 'isFile'
					},
					{
						expand: true,
						cwd: 'app',
						src: ['models/**'],
						dest: '<%= itlconfig.production %>/app',
						filter: 'isFile'
					}
				]
			}
		},

		uglify: {
			options: {
				// the banner is inserted at the top of the output
				banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
				preserveComments: false,
				// Specify mangle: false to prevent changes to your variable and function names.
				mangle: false
			},
			wd: {
				src: ['assets/js/itl.js'],
				dest: '.tmp/public/min/itl.js'
			},
			dist: {
				src: ['.tmp/public/concat/production.js'],
				dest: '.tmp/public/min/production.js'
			},
			prod: {
				// src: ['<%= itlconfig.webroot %>/js/app.js'],
				// dest: '<%= itlconfig.asset %>/js/app.js'
				files: [
					{
						src: ['<%= itlconfig.webroot %>/js/app.js'],
						dest: '<%= itlconfig.asset %>/js/app.js'
					},
					{
						src: ['<%= itlconfig.webroot %>/js/jquery.main.js'],
						dest: '<%= itlconfig.asset %>/js/jquery.main.js'
					}
				]
			}
		},

		htmlmin: {
			options: {
				removeComments: true,
				collapseWhitespace: true
			},
			prod: {
				files: [
					{
						'<%= itlconfig.asset %>/index.html': '<%= itlconfig.webroot %>/index.html'
					},
					{
						expand: true,
						cwd: '<%= itlconfig.webroot %>/templates',
						src: '**/*.html',
						dest: '<%= itlconfig.asset %>/templates',
						filter: 'isFile'
					},
				]
			}
		},
		// https://github.com/gruntjs/grunt-contrib-cssmin
		cssmin: {
			options: {
				shorthandCompacting: false,
				roundingPrecision: -1
			},
			dist: {
				files: [{
					expand: true,
					cwd: 'public/css',
					src: ['*.css', '!*.min.css'],
					dest: '<%= itlconfig.asset %>/css',
					filter: 'isFile'
				}]
			}
		},

		csslint: {
			strict: {
				options: {
					import: 2
				},
				src: ['assets/css/don.css']
			},
			lax: {
				options: {
					import: false
				},
				src: ['assets/**/*.css']
			}
		},

		concat: {
			js: {
				src: ['assets/js/app.js', 'assets/js/imagesloaded.pkgd.min.js', 'assets/js/masonry.pkgd.min.js', 'assets/js/jquery.infinitescroll.min.js', 'assets/js/parsley.min.js', 'assets/js/itl.js'],
				dest: '.tmp/public/concat/production.js'
			},
			css: {
			}
		},
		
		watch: {
			options: {
				// livereload: true,
				interrupt: true,
				dateFormat: function(time) {
					grunt.log.writeln('The watch finished in ' + time + 'ms at ' + (new Date()).toString());
					grunt.log.writeln('Waiting for more changes...');
					grunt.log.writeln('');
				},
			},
			configFiles: {
				files: [ 'Gruntfile.js', 'package.json'],
				tasks: ['jshint'],
				options: {
					reload: true,
				}
			},
			php: {
				files: ['app/config/*.php', 'app/controllers/*.php', 'app/models/*.php', 'public/index.php'],
				tasks: ['phplint:all'],
				options: {
					reload: true
				}
			},
			js: {
				// API files to watch:
				files: ['public/js/**/*'],
				tasks: ['jshint'],
				options: {
					// reload: true,
					// livereload: 35729

					// livereload: true
				}
			},
			html: {
				// Views files to watch:
				files: ['public/index.html', 'public/templates/**/*'],
				options: {
					// livereload: true
					
					// reload: true,
					// livereload: 35729
				}
			},
		}
	});

	grunt.event.on('watch', function(action, filepath, target) {
		grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
	});

	grunt.registerTask('default', ['phplint:all', 'jshint']);
	grunt.registerTask('itl_watch', ['phplint:all', 'jshint', 'watch']);

	grunt.registerTask('precommit', ['phplint:all', 'phpunit:unit']);
	grunt.registerTask('server', ['php']); 

	grunt.registerTask('js', [
		'jshint',
	]);

	grunt.registerTask('css', [
		//'clean:dev',
		'copy:dev',
		'concat',
		'uglify:itl',
		'cssmin'
	]);
	
	// Build the assets into a web accessible folder.
	// (handy for phone gap apps, chrome extensions, etc.)
	grunt.registerTask('build', [
		'compileAssets',
		'linkAssets',
		'clean:build',
		'copy:build'
	]);

	// production
	grunt.registerTask('prod', [
		'clean:prod',
		'copy:prod',
		'uglify:prod',
		'htmlmin:prod',
	]);

	/*
	grunt.registerTask('default', [
		//'jshint',
		//'csslint:strict'
		'clean:dev',
		'copy:dev',
		'concat',
		//'uglify:itl',
		'cssmin',
		'watch'
	]);
	*/
};
