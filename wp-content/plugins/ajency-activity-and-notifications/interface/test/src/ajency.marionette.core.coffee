# Vendors
$ = require "jquery"
require("backbone").$ = $ || jQuery
Backbone = require "backbone"
Mustache = require "mustache"
Marionette = require "backbone.marionette"

_ = require 'underscore'

_.templateSettings =
        evaluate: /\{\[([\s\S]+?)\]\}/g,
        interpolate: /\{\{([\s\S]+?)\}\}/g

# marionette controller holder
Marionette._ctrl = {}

# options = ( region : regionName, ctrl : CtrlNameOrClass, args : Object)
Marionette.run = (options)->
	CtrlClass = Marionette._ctrl[options['ctrl']]
	new CtrlClass
		region : options['region']
		options : options['args']

# overwrite the default rendering engine to mustache
Marionette.Renderer.render = (template, data)->
    if not template
        template = ''

    if typeof template is "function"
        template = template()

    Mustache.to_html template, data
