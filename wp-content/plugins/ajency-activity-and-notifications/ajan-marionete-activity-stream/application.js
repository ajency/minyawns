window.app = new Marionette.Application();

app.addRegions({
  main: "#main-region",
  sideBar: "#sidebar-region"
});

app.module("aj-activity-stream", AjActivityStreamModule);

app.on('start', function(){
	Marionette.run({
			region : app.sideBar,
			ctrl : 'ActivityStreamCtrl',
			args :{
				objectId : 23,
				posttype : 'job',
				style : 'default'
			}
		});
});
app.start();



Backbone.history.start();
