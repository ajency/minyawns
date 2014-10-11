define [
  "App"
  "backbone"
  "marionette"
  "views/WelcomeView"
  "views/MobileHeaderView"
], (App, Backbone, Marionette, WelcomeView, MobileHeaderView) ->
  Backbone.Marionette.Controller.extend
    initialize: (options) ->
      App.headerRegion.show new MobileHeaderView()
      return

    
    #gets mapped to in AppRouter's appRoutes
    index: ->
      App.mainRegion.show new WelcomeView()
      return

