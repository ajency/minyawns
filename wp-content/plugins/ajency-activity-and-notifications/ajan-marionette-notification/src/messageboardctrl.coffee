class MessageBoardCtrl extends Marionette.Controller

	initialize : (options = {})->
		#super options
		options.region.show new NotificationView 'template' : '<h2>New template diana</h2>'

# message board ctrl
Marionette._ctrl['MessageBoardCtrl'] = MessageBoardCtrl

