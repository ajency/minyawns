define [
  "App"
  "backbone"
  "marionette"
  "views/WelcomeView"
  "views/DesktopHeaderView"
], (App, Backbone, Marionette, WelcomeView, DesktopHeaderView) ->
  Backbone.Marionette.Controller.extend
    initialize: (options) ->
      console.log "in controller"
      App.discussionRegion.show new WelcomeView()
      return

    
    #gets mapped to in AppRouter's appRoutes
    index: ->