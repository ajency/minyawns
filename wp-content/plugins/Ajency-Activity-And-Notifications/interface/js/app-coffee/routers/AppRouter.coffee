define [
  "backbone"
  "marionette"
], (Backbone, Marionette) ->
  
  #"index" must be a method in AppRouter's controller
  Backbone.Marionette.AppRouter.extend appRoutes:
    "": "index"