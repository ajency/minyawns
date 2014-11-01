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

        @listenTo view ,"fetch:all:comments" , @_getAllComments

        @listenTo view, "change:user:info" , @_displayUserInfo

        @listenTo view , "save:new:activity" , @_saveActivity

        @listenTo view , "save:new:comment" , @_saveComment

        @listenTo view , "delete:activity" , @_deleteActivity

        @listenTo view , "delete:comment" , @_deleteComment

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

      _saveComment:(data)->
        console.log "controller save comment" 
        commentModel = App.request "create:new:comment", data
        commentModel.save null,
                emulateJSON : true, 
                wait: true
                success : @_commentAdded

      _activityAdded :(model,response)=>
        console.log "controller added activity"
        App.execute "add:new:activity:model", model
        @view.triggerMethod "added:activity:model"
        

      _commentAdded :(model,response)=>
        console.log "controller added comment"
        @commentCollection.add model 
        console.log @commentCollection
        App.execute "add:new:comment:model", model
        @view.triggerMethod "added:comment:model" , model

      _getLatestComments:->
        console.log "get latest comments"
        activity_ids = @activityCollection.pluck("id"); 
        activity_ids = activity_ids.join() 
        @commentCollection = new App.Entities.Comment.CommentCollection
        @commentCollection.fetch   
          data:
            activity_parent : activity_ids
            item_id : ajan_item_id
            records : 3
          success: (collection, response)=>
            @view.triggerMethod "activity:comments:fetched" , collection

      _getAllComments:(activity)->
        console.log "get All comments" 
        @commentCollection = new App.Entities.Comment.CommentCollection
        @commentCollection.fetch   
          data:
            activity_parent : activity
            item_id : ajan_item_id
            records : ''
          success: (collection, response)=>
            console.log collection.length
            @view.triggerMethod "activity:comments:fetched" , collection, activity


      _deleteActivity:(activity)->  
        model =  @activityCollection.get activity 
        model.destroy
          success: (status, response)=>
            console.log "status"

      _deleteComment:(activity)->  
        console.log "_deleteComment"
        console.log @commentCollection
        model =  @commentCollection.get activity 
        model.destroy
          success: (status, response)=>
            console.log "status"
            @view.triggerMethod "activity:comment:deleted" , activity
       

    App.commands.setHandler "show:activity:package", (opt = {})->
      new activitystreamcontroller opt

