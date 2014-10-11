
# Include Desktop Specific JavaScript files here (or inside of your Desktop Controller, or differentiate based off App.mobile === false)
require [
  "App"
  "routers/AppRouter"
  "controllers/DesktopController"
  "jquery"
  "backbone"
  "marionette"
  "jqueryui"
  "bootstrap"
  "backbone.validateAll"
], (App, AppRouter, AppController) ->
  console.log "controller"
  App.appRouter = new AppRouter(controller: new AppController())
  
  # Start Marionette Application in desktop mode (default)
  App.start()
  return
 