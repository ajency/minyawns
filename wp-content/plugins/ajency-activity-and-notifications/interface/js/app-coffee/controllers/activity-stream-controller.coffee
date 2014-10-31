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

        @listenTo view ,"get:user:info" , @_getUsers

        @listenTo view ,"fetch:latest:comments" , @_getLatestComments

        @listenTo view, "change:user:info" , @_displayUserInfo

        @listenTo view , "save:new:activity" , @_saveActivity

        App.execute "when:fetched", [@activityCollection], =>
          @show view

       
      _getView: (activityCollection) -> 
        new ListActivity.Views.ShowPackage
          collection : activityCollection

      _getUsers:() ->
        if _.isUndefined(@userCollection)
          @userCollection = new App.Entities.User.UserCollection

        user_ids = @activityCollection.pluck("user_id");
        fetcheduser_ids = @userCollection.pluck("ID");
        #user_ids =   _.difference( _.uniq(user_ids),fetcheduser_ids);
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

      _activityAdded :(model,response)=>
        console.log "controller added activity"
        App.execute "add:new:activity:model", model
        @view.triggerMethod "added:activity:model" 

      _getLatestComments:->
        console.log "get latest comments"
        activity_ids = @activityCollection.pluck("id"); 
        activity_ids = activity_ids.join() 
        data=
          activity_parent : activity_ids
          item_id : ajan_item_id
          records : 3
        @commentCollection = App.request "get:comment:collection" , data
       

    App.commands.setHandler "show:activity:package", (opt = {})->
      new activitystreamcontroller opt

