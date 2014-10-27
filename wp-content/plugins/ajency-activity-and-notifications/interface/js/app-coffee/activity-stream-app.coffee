define [
    "marionette"
    
], (Marionette ) ->
  isMobile = ->
    userAgent = navigator.userAgent or navigator.vendor or window.opera
    (/iPhone|iPod|iPad|Android|BlackBerry|Opera Mini|IEMobile/).test userAgent
  window.App = new Marionette.Application;

  #Organize Application into regions corresponding to DOM elements
  #Regions can contain views, Layouts, or subregions nested as necessary
  console.log "appstrt"+ajan_activity_stream_container
  App.addRegions activitystreamRegion: ajan_activity_stream_container


  # Reqres handler to return a default region. If a controller is not explicitly specified a 
  # region it will trigger default region handler
  App.reqres.setHandler "default:region", ->
    App.activitystreamRegion

  App.commands.setHandler "when:fetched", (entities, callback) ->
    xhrs = _.chain([entities]).flatten().pluck("_fetch").value()
    $.when(xhrs...).done ->
      callback()
      
  App.on "initialize:after", (options) ->
    console.log "intiapp"
    Backbone.history.start()
    App.execute "show:activity:package", region: App.activitystreamRegion
  App
