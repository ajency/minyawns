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

        @listenTo view ,"fetch:latest:comments" , @_getLatestComments

        @listenTo view, "change:user:info" , @_displayUserInfo

        @listenTo view , "save:new:activity" , @_saveActivity

        App.execute "when:fetched", [@activityCollection], =>
          @show view

       
      _getView: (activityCollection) -> 
        new ListActivity.Views.ShowPackage
          collection : activityCollection

      _getUsers:() ->
        @userCollection = new App.Entities.User.UserCollection
        user_ids = @activityCollection.pluck("user_id");
        #fetcheduser_ids = @userCollection.pluck("id");
        #user_ids = arr_diff(fetcheduser_ids,user_ids);
        #console.log  "user_ids"
        #console.log  fetcheduser_ids
        console.log  @activityCollection

        user_ids =_.uniq(user_ids).join() 

        
        @userCollection.fetch   
          data:
            users : user_ids
            item_id: ajan_item_id
          success: (collection, response)=>
            @view.triggerMethod "change:user:image" , collection

      _saveActivity:(data)->
        console.log "controller save activity" 
        activityModel = App.request "create:new:activity", data
        activityModel.save null,
                emulateJSON : true, 
                wait: true
                success : @_activityAdded
                error : console.log "error saving"

      _activityAdded :(model,response)=>
        console.log "controller added activity"
        App.execute "add:new:activity:model", model
        @view.triggerMethod "activity:added" 

      _getLatestComments:->
         console.log "get latest comments"
       

    App.commands.setHandler "show:activity:package", (opt = {})->
      new activitystreamcontroller opt

