window.app = new Marionette.Application();

app.addRegions({
  main: "#main-region",
  sideBar: "#sidebar-region"
});

app.module("aj-notification", AjNotificationModule);

app.on('start', function(){
	Marionette.run({
			region : app.sideBar,
			ctrl : 'MessageBoardCtrl',
			args :{
				objectId : 23,
				posttype : 'job',
				style : 'default'
			}
		});
});
app.start();



Backbone.history.start();
