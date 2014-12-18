((root, factory) ->
	Backbone = undefined
	Marionette = undefined
	_ = undefined
	if typeof define is "function" and define.amd
		define [
			"backbone"
			"underscore"
			"backbone.marionette"
		], (Backbone, _) ->
			root.AjNotificationModule = factory(root, Backbone, _)

	else if typeof exports isnt "undefined"
		Backbone = require("backbone")
		_ = require("underscore")
		Marionette = require("backbone.marionette")
		module.exports = factory(root, Backbone, _, Marionette)
	else
		root.AjNotificationModule = factory(root, root.Backbone, root._, root.Marionette)

) this, (root, Backbone, _, Marionette) ->
	"use strict"

	# @include notificationview.coffee
	# @include messageboardctrl.coffee
	# @include notificationmodel.coffee
	# @include aj-notification.coffee

	AjNotificationModule
