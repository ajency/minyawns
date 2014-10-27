define ['app' , 'backbone'], (App) ->
App.module "Entities.User", (User, App)->
#define user model
class User extends Backbone.Model
idAttribute : 'ID'
defaults:
display_name : ''
role : ''
user_registered : ''
user_email : ''
checked : ''
name : 'user'
#define user collection
class UserCollection extends Backbone.Collection
model : User
url : -> #ajax call to return a list of all the users from the databse
AJAXURL + '?action=get-users'
# declare a user collection instance
userCollection = new UserCollection
# API
API =
getUsers:-> #returns a collection of users
userCollection.fetch()
userCollection
saveUser :(data={})-> #creates a new instance of the model
userSingle = new User data
userSingle
addUser :(model)->#adda a model to the collection
userCollection.add(model)
editUser :(id)->#update a model to the collection
user = userCollection.get id
if not user
user = new User ID : id
userCollection.add(user)
user
# Handlers
App.reqres.setHandler "get:user:collection", ->
API.getUsers()
App.reqres.setHandler "create:user:model", (data)->
API.saveUser data
App.commands.setHandler "add:new:user:model" , (model)->
API.addUser model
App.reqres.setHandler "get:user:data", (id)->
API.editUser id
