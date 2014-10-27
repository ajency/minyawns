define ['startapp' , 'backbone'], (App) ->

  App.module "Entities.User", (Activity, App)->

    # define the User model
    class User extends Backbone.Model

      idAttribute : 'ID'

      defaults:
        ID: ""
        name: ""
        profile_pic: ""
        profile_url: "" 


      name : 'activity'

      
    # define the menu collection
    class ActivityCollection extends Backbone.Collection

      model : Activity
      
      url : ->
        SITEURL + ajan_get_activities_uri
        
    activityCollection = new ActivityCollection
    myarray = []
    

    # API

    activityCollection.fetch()
    API =   
      getActivities:->
        activityCollection
        

    
    App.reqres.setHandler "get:activity:collection", (data)->
      API.getActivities() 