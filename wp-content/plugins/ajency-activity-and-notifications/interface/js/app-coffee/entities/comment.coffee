define ['startapp' , 'backbone'], (App) ->

  App.module "Entities.Comment", (Comment, App)->

    # define the Activity model
    class CommentModel extends Backbone.Model
 

      defaults:
        
        user_id: ""
        component: ""
        type: ""
        action: ""
        content: ""
        item_id: ""
        secondary_item_id: ""
        date_recorded: ""
        comment_count: ""
        nonce:ACTIVITY_NONCE_STRING


      name : 'comment'

      urlRoot : SITEURL + ajan_post_comments_uri
 
      
    # define the menu collection
    class Comment.CommentCollection extends Backbone.Collection

      model : CommentModel
      
      url : ->
        SITEURL + ajan_get_comments_uri

      parse :(response)->
        response.collection
        
    commentCollection = new Comment.CommentCollection

    API =    
        
      saveComment:(data)->

        ajan_post_data = ajan_post_activities_uri
        console.log "entity save comment"
        comment = new CommentModel data
        console.log comment
        comment

      addComment :(model)->
        console.log "model add activity"
        commentCollection.add model

    App.reqres.setHandler "create:new:comment", (data)->
      API.saveComment data

    App.commands.setHandler "add:new:comment:model", (model)->
      API.addComment model
    

