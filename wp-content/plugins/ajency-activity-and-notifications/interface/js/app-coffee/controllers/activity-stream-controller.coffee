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

        @listenTo view ,"new:user:info" , @_getUsers

        App.execute "when:fetched", [@activityCollection], =>
          @show view

       
      _getView: (activityCollection) -> 
        new ListActivity.Views.ShowPackage
          collection : activityCollection

      _getUsers:() ->

        user_ids = @activityCollection.pluck("user_id");
        user_ids =_.uniq(user_ids).join()  

        @userCollection = App.request "get:user:collection", 
          users : user_ids 
        App.execute "when:fetched", [@userCollection], =>
          console.log "usercol"
          console.log @userCollection
          

    App.commands.setHandler "show:activity:package", (opt = {})->
      new activitystreamcontroller opt

