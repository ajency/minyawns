_ = require 'underscore'
Marionette = require 'backbone.marionette'
Backbone = require 'backbone'

NotificationModel = require './entities/notificationmodel.coffee'
MessageBoardCtrl = require './controllers/messageboardctrl.coffee'

class AjNotificationModule extends Marionette.Module

	initialize : (options = {})->
		super options

	onStart: ->
		Marionette.run
				region : @app.sideBar
				ctrl : 'MessageBoardCtrl'
				args :
					objectId : 23
					posttype : 'job'
					style : 'default'

	# onStop: ->


module.exports = AjNotificationModule

