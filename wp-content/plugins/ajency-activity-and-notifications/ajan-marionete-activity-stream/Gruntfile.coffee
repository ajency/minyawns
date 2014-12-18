
_ = require 'underscore'

module.exports = (grunt) ->

	require("load-grunt-tasks") grunt

	grunt.initConfig

		preprocess :
			dev:
				src: "src/build.file.coffee"
				dest: "src/aj-activity-stream-module.coffee"


		# produce index.html by target
		targethtml:
			dev:
				src: "example/index.html"
				dest: "index.html"

			prod:
				src: "example/index.html"
				dest: "index.html"

		coffee :
			options :
				bare : true
			app :
				files :
					"dist/aj-activity-stream.js" : "src/aj-activity-stream-module.coffee"

		uglify:
			bundle:
				src: "dist/aj-activity-stream.js"
				dest: "dist/aj-activity-stream.min.js"

		watch:
			options:
				livereload: true
				spawn: false
				interrupt: true

			src:
				files: [
					"src/*.coffee"
					"example/**/*.html"
				]
				tasks: ["preprocess:dev", "coffee:app"]

			index:
				files: ["example/index.html"]
				tasks: ["targethtml:dev"]

		connect:
			server:
				options:
					hostname: "127.0.0.1"
					open: true
					useAvailablePort: true
					livereload: true

	grunt.registerTask "builddev", [
		"targethtml:dev"
	]
	grunt.registerTask "buildprod", [
		"uglify"
	]
	grunt.registerTask "run", [
		"builddev"
		"coffee:app"
		"preprocess:dev"
		"connect"
		"watch"
	]
