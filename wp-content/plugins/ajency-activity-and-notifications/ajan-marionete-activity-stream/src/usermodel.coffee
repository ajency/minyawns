class UserModel extends Backbone.Model

	idAttribute : 'ID'
	defaults:
		ID: ""
		name: ""
		profile_pic: ""
		profile_url: "" 


	name : 'user'
 

# define the User collection
class UserCollection extends Backbone.Collection

	model : UserModel
			
	url : ->
		AJANSITEURL + '/api/users'

	parse :(response)->
		response.collection
				
userCollection = new UserCollection 