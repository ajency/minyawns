define [
  "startapp"
  "backbone"
  "marionette"
  "app/views/activity-stream-view",
  "app/controllers/region-controller"
], (App, Backbone, Marionette, ActivityStreamView,RegionController) ->

  App.module "ListActivity", (ListActivity, App) ->

    class activitystreamcontroller extends RegionController
      initialize  :->
        @activityCollection = App.request "get:activity:collection"
        @view = view = @_getView @activityCollection 
        App.execute "when:fetched", [@activityCollection], =>
        @show view
       
      _getView: (activityCollection) -> 
        console.log "activityCollection"
        console.log activityCollection
        new ListActivity.Views.ShowPackage
          collection : activityCollection
          

    App.commands.setHandler "show:activity:package", (opt = {})->
      new activitystreamcontroller opt

