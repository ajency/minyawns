define [
  "jquery"
  "backbone"
  "marionette"
  "underscore"
  "handlebars"
], ($, Backbone, Marionette, _, Handlebars) ->
  isMobile = ->
    userAgent = navigator.userAgent or navigator.vendor or window.opera
    (/iPhone|iPod|iPad|Android|BlackBerry|Opera Mini|IEMobile/).test userAgent
  App = new Backbone.Marionette.Application()
  
  #Organize Application into regions corresponding to DOM elements
  #Regions can contain views, Layouts, or subregions nested as necessary
  App.addRegions discussionRegion: discussion_container
  App.addInitializer ->
    Backbone.history.start()
    return

  App.mobile = isMobile()
  App
