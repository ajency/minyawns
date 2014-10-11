define [
  "jquery"
  "hbs!templates/desktopHeader"
  "backbone"
  "marionette"
], ($, template, Backbone) ->
  
  #ItemView provides some default rendering logic
  Backbone.Marionette.ItemView.extend template: template