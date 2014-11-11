Backbone = require 'backbone'
_ = require 'underscore'
class NotificationModel extends Backbone.Model

	defaults : ->
		id : _.random(0,100)
		name : 'NotificationModel' + _.random(0,100)

	save : ->
		console.log 'Save locally'

module.exports = NotificationModel
