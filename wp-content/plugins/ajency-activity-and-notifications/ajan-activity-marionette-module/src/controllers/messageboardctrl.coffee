Backbone = require 'backbone'
_ = require 'underscore'
Marionette = require 'backbone.marionette'
NotificationView = require '../views/notificationview.coffee'

class MessageBoardCtrl extends Marionette.Controller

	initialize : (options = {})->
		#super options
		options.region.show new NotificationView 'template' : '<h2>New template WEDnesday</h2>'

# message board ctrl
Marionette._ctrl['MessageBoardCtrl'] = MessageBoardCtrl

module.exports = MessageBoardCtrl
