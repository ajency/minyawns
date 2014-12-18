class IView extends Marionette.ItemView
	template : '{{ id }}<br /><div>{{ name }}</div>'
	className : 'single-notification'

class NotificationView extends Marionette.CompositeView
	template : 'Some container needed<ul class="notification-container"></ul>'
	className : 'notification-class'
	childView : IView
	childViewContainer : '.notification-container'
