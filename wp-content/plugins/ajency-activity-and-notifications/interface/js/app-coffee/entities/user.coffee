define ['startapp' , 'backbone'], (App) ->

  App.module "Entities.User", (User, App)->

    # define the User model
    class UserModel extends Backbone.Model

      idAttribute : 'ID'
      defaults:
        ID: ""
        name: ""
        profile_pic: ""
        profile_url: "" 


      name : 'user'

      
    # define the User collection
    class User.UserCollection extends Backbone.Collection

      model : UserModel
      
      url : ->
        SITEURL + '/api/users'

      parse :(response)->
        response.collection
        
    userCollection = new User.UserCollection 

     
        

    
