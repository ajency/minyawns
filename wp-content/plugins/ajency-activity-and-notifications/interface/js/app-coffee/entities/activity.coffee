define ['startapp' , 'backbone'], (App) ->

  App.module "Entities.Activity", (Activity, App)->

    # define the Activity model
    class Activity extends Backbone.Model

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


      name : 'activity'

      urlRoot : SITEURL + ajan_post_activities_uri
 
      
    # define the menu collection
    class ActivityCollection extends Backbone.Collection

      model : Activity
      
      url : ->
        SITEURL + ajan_get_activities_uri

      parse :(response)->
        response.collection
        
    activityCollection = new ActivityCollection
    myarray = []
    

    # API

    activityCollection.fetch()
    API =   
      getActivities:->
        activityCollection
        
      saveActivity:(data)->

        ajan_post_data = ajan_post_activities_uri
        console.log "entity save activity"
        activity = new Activity data
        console.log activity
        activity

      addActivity :(model)->
        console.log "model add activity"
        activityCollection.add model

      getSingleActivity:(ID)->
        activityModel = activityCollection.get ID
        
    
    App.reqres.setHandler "get:activity:collection", (data)->
      API.getActivities() 

    App.reqres.setHandler "create:new:activity", (data)->
      API.saveActivity data

    App.commands.setHandler "add:new:activity:model", (model)->
      API.addActivity model

    App.reqres.setHandler  "get:activity:model" , (ID)->
      API.getSingleActivity ID