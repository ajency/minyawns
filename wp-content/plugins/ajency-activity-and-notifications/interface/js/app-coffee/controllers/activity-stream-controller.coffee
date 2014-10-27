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

        @listenTo view, "change:user:info" , @_displayUserInfo

        App.execute "when:fetched", [@activityCollection], =>
          @show view

       
      _getView: (activityCollection) -> 
        new ListActivity.Views.ShowPackage
          collection : activityCollection

      _getUsers:() ->

        user_ids = @activityCollection.pluck("user_id");
        user_ids =_.uniq(user_ids).join()  

        @userCollection = new App.Entities.User.UserCollection
        @userCollection.fetch   
          data:
            users : user_ids 
          success: (c, y)->
            @view.triggerMethod "change:user:info" , c
          
      _displayUserInfo:() ->
        console.log "displayuserCollection"
        console.log @userCollection 
        _.each @userCollection, (property, index)->
                console.log "property"
                console.log property

    App.commands.setHandler "show:activity:package", (opt = {})->
      new activitystreamcontroller opt

