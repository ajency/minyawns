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

	class IView extends Marionette.ItemView
		template : '{{ id }}<br /><div>{{ name }}</div>'
		className : 'single-notification'
	
	class NotificationView extends Marionette.CompositeView
		template : 'Some container needed<ul class="notification-container"></ul>'
		className : 'notification-class'
		childView : IView
		childViewContainer : '.notification-container'
	
	class MessageBoardCtrl extends Marionette.Controller
	
		initialize : (options = {})->
			#super options
			options.region.show new NotificationView 'template' : '<h2>New templae</h2>'
	
	# message board ctrl
	Marionette._ctrl['MessageBoardCtrl'] = MessageBoardCtrl
	
	
	class NotificationModel extends Backbone.Model
	
		defaults : ->
			id : _.random(0,100)
			name : 'NotificationModel' + _.random(0,100)
	
		save : ->
			console.log 'Save locally'
	
	class AjNotificationModule extends Marionette.Module
	
		initialize : (options = {})->
			super options
	

	AjNotificationModule
