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


      name : 'activity'

      
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
        

    
    App.reqres.setHandler "get:activity:collection", (data)->
      API.getActivities() 