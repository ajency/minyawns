define ['startapp' , 'backbone'], (App) ->

  App.module "Entities.Comment", (Activity, App)->

    # define the Activity model
    class Comment extends Backbone.Model

      idAttribute : 'ID'

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

      urlRoot : ->
        SITEURL + ajan_post_comments_uri
 
      
    # define the menu collection
    class CommentCollection extends Backbone.Collection

      model : Comment
      
      url : ->
        SITEURL + ajan_get_comments_uri

      parse :(response)->
        response.collection
        
    commentCollection = new CommentCollection
    myarray = []
    

    # API

    commentCollection.fetch()
    API =   
      getComments:(data)->
        console.log("data")
        console.log(data)
        commentCollection.fetch
          data:data
        
      saveComment:(data)->
        console.log "entity save comment"
        comment = new Activity data
        console.log comment
        comment

      addComment :(model)->
        console.log "model add comment"
        commentCollection.add model

      getSingleComment:(ID)->
        commentModel = commentCollection.get ID
        
    
    App.reqres.setHandler "get:comment:collection", (data)->
      API.getComments(data) 

    App.reqres.setHandler "create:new:comment", (data)->
      API.saveComment data

    App.commands.setHandler "add:new:comment:model", (model)->
      API.addComment model

    App.reqres.setHandler  "get:comment:model" , (ID)->
      API.getSingleComment ID