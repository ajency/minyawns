 
function loadPluginActivityStream(job_id){

		window.app = new Marionette.Application();

	app.addRegions({ 
	  activityContainer: "#ajan-activity-stream-container"
	});

	app.module("aj-activity-stream", AjActivityStreamModule);

	app.on('start', function(){
		Marionette.run({
				region : app.activityContainer,
				ctrl : 'ActivityStreamCtrl',
				args :{
					item_id : job_id, 
				}
			});
	});
	app.start();
}

 