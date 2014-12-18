class ActivityStreamCtrl extends Marionette.Controller



	initialize  :(options)->
		@options = options

		@currentActivityCollection = new ActivityCollection(options)

		@activityCollection = new ActivityCollection(options)

		@userCollection = new UserCollection(options)

		@commentCollection = new CommentCollection(options)

		@view = view = @_getView @currentActivityCollection 
		@activityCollection.fetch
			wait: true
			data:
				item_id : options.item_id 
			success: (collection, response)=>
				console.log "collectionshow"
				console.log collection
				@currentActivityCollection.reset(collection.toJSON())  
				@show @view 

		#now @currentActivityCollection = App.request "get:current:activity:collection"


		@listenTo view ,"get:user:info" , @_getUsers

		@listenTo view ,"fetch:latest:comments" , @_getLatestComments

		@listenTo view ,"create:filters" , @_createFilters

		@listenTo view ,"fetch:all:comments" , @_getAllComments

		@listenTo view, "change:user:info" , @_displayUserInfo

		@listenTo view , "save:new:activity" , @_saveActivity

		@listenTo view , "save:new:comment" , @_saveComment

		@listenTo view , "delete:activity" , @_deleteActivity

		@listenTo view , "delete:comment" , @_deleteComment

		@listenTo view , "filter:activity" , @_filterActivity


		@listenTo view , "delete:comment" , @_deleteComment

		@listenTo @activityCollection , "add" , @_triggerFilter


		#now App.execute "when:fetched", [@activityCollection], =>
			#now @currentActivityCollection.reset(@activityCollection.toJSON())
			#now @show view

	show:(view) =>
		@options.region.show @view

	_getView: (activityCollection) -> 
		new ShowPackage
			collection :  activityCollection

	_getUsers:() -> 
		#now if _.isUndefined(@userCollection)
			#now @userCollection = new App.Entities.User.UserCollection

		user_ids = @activityCollection.pluck("user_id");
		fetcheduser_ids = @userCollection.pluck("ID");
		user_ids =   _.difference( _.uniq(user_ids),fetcheduser_ids);
		user_ids =_.uniq(user_ids).join() 

		
		@userCollection.fetch   
			data:
				users : user_ids
				item_id: @options.item_id
			success: (collection, response)=>
				@view.triggerMethod "change:user:image" , collection

	_createFilters:(selectedFilter) ->
		componentType = _.uniq(@activityCollection.pluck("type"));
		@view.triggerMethod "generate:filters" , componentType ,selectedFilter


	_saveActivity:(data)-> 
		data.item_id = @options.options.item_id
		activityModel = new ActivityModel data
		activityModel.save null,
			emulateJSON : true, 
			wait: true
			success : @_activityAdded

	_saveComment:(data)->
		data.item_id = @options.options.item_id
		commentModel = new CommentModel(data)
		commentModel.save null,
						emulateJSON : true, 
						wait: true
						success : @_commentAdded

	_activityAdded :(model,response)=>
		@activityCollection.unshift model 
		#now App.execute "add:new:activity:model", model
		@view.triggerMethod "added:activity:model"
		

	_commentAdded :(model,response)=>
		@commentCollection.add model 
		secondary_item_id = model.get("secondary_item_id") 
		parentModel = @activityCollection.get(secondary_item_id)
		clonedParentModel = @currentActivityCollection.get(secondary_item_id) 
		comment_count = parentModel.get("comment_count") 
		parentModel.set("comment_count",comment_count+1 )
		clonedParentModel.set("comment_count",comment_count+1 )
		@currentActivityCollection.add clonedParentModel
		@activityCollection.add parentModel
		@view.triggerMethod "added:comment:model" , model

	_getLatestComments:-> 
		console.log "_getLatestComments"
		activity_ids = @activityCollection.pluck("id"); 
		activity_ids = activity_ids.join() 
		#now @commentCollection = new App.Entities.Comment.CommentCollection
		@commentCollection.fetch   
			data:
				activity_parent : activity_ids
				item_id : @options.item_id
				records : 3
			success: (collection, response)=>
				console.log "_getLatestComments fetched"
				@view.triggerMethod "activity:comments:fetched" , collection

	_getAllComments:(activity)->
		#now @commentCollection = new App.Entities.Comment.CommentCollection
		@commentCollection.fetch   
			data:
				activity_parent : activity
				item_id : @options.item_id
				records : ''
			success: (collection, response)=>
				@view.triggerMethod "activity:comments:fetched" , collection, activity


	_deleteActivity:(activity)->  
		model =  @activityCollection.get activity 
		model.destroy
			success: (status, response)=>
				console.log "status"
				@currentActivityCollection.remove(model)


	_deleteComment:(activity)->  
		model =  @commentCollection.get activity
		secondary_item_id = model.get("secondary_item_id") 
		model.destroy
			success: (status, response)=>
				parentModel = @activityCollection.get(secondary_item_id)
				clonedParentModel = @currentActivityCollection.get(secondary_item_id) 
				comment_count = parentModel.get("comment_count") 
				parentModel.set("comment_count",comment_count-1 )
				clonedParentModel.set("comment_count",comment_count-1 )
				@currentActivityCollection.add clonedParentModel
				@activityCollection.add parentModel
				@view.triggerMethod "activity:comment:deleted" , activity

	_filterActivity:(filterBy)->   
		if filterBy ==""
			@currentActivityCollection.reset(@activityCollection.toJSON())  
		else
			filteredActivityCollection = _.where(@activityCollection.toJSON(),
																type: filterBy
															) 
			@currentActivityCollection.reset(filteredActivityCollection)

	_triggerFilter:->
		@view.triggerMethod "trigger:activity:filter" 

				 
			 


# message board ctrl
Marionette._ctrl['ActivityStreamCtrl'] = ActivityStreamCtrl

