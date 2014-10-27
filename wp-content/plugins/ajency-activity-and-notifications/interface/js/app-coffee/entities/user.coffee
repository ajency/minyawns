define ['startapp' , 'backbone'], (App) ->

  App.module "Entities.User", (User, App)->

    # define the User model
    class User extends Backbone.Model

      idAttribute : 'ID'

      defaults:
        ID: ""
        name: ""
        profile_pic: ""
        profile_url: "" 


      name : 'user'

      
    # define the menu collection
    class UserCollection extends Backbone.Collection

      model : User
      
      url : ->
        SITEURL + '/api/users'

      parse :(response)->
        response.collection
        
    userCollection = new UserCollection 

    # API

    userCollection.fetch()
    API =   
      getUsers:(opt)-> #returns a collection of customers
        userCollection.fetch
          data : 
            users : opt.users 
        userCollection
        

    
    App.reqres.setHandler "get:user:collection", (opt)-> 
      API.getUsers(opt) 