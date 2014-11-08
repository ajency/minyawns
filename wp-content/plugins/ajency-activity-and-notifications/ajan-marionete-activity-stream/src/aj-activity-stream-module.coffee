((root, factory) ->
	Backbone = undefined
	Marionette = undefined
	_ = undefined
	if typeof define is "function" and define.amd
		define [
			"backbone"
			"underscore"
			"backbone.marionette"
		], (Backbone, _) ->
			root.AjActivityStreamModule = factory(root, Backbone, _)

	else if typeof exports isnt "undefined"
		Backbone = require("backbone")
		_ = require("underscore")
		Marionette = require("backbone.marionette")
		module.exports = factory(root, Backbone, _, Marionette)
	else
		root.AjActivityStreamModule = factory(root, root.Backbone, root._, root.Marionette)

) this, (root, Backbone, _, Marionette) ->
	"use strict"

	class ActivityModel extends Backbone.Model
	
	
		defaults :
	        
	        user_id : ""
	        component : ""
	        type : ""
	        action : ""
	        content : ""
	        item_id : ""
	        secondary_item_id : ""
	        date_recorded : ""
	        comment_count : "" 
	
	
	      name : 'activity'
	
		urlRoot : AJANSITEURL+"/api/activities"
	
		sync : (method, model, options)-> 
			sendmethod = method
			if method is "create"
				sendmethod = "POST"
			# check if the name property is set for the model
			# this property is important because the “action”
			# param required for wordpress ajax is generated 
			# combining “#{method}-#{name}”
			
			if not @name
				throw new Error "'name' property not set for the model"
			
			# Default JSON-request options.
			params =
				type : sendmethod
				dataType: "json"
				data : {}
				
			# All ajax request in wordpress are sent to admin_url(‘admin-ajax.php’)
			# a global AJAXURL variable must be defined for all ajax actions
			# so, the url is always AJAXURL
			console.log model 
			if method is "delete"
			  params.url =  @urlRoot+"/"+ model.get("id")
			else
			  params.url =  @urlRoot 
			
			
			# generate the “action” param and bind it to data attribute of ‘params’
			_action = "#{method}-#{@name}"
			params.data['action'] = _action	
			
			# handle various CRUD operations depending on method name
			switch method
			
				# read a model form server. the only property read a model from server is the 
				# id attribute of the model. 
				when 'read'
					# read action must trigger a GET request. set the request to GET
					params.type = 'GET'
					
					# get the id attribute of the model
					idAttr = model['idAttribute']
					params.data[idAttr] = model.get idAttr
	
					
					
				# create a new model. At this point the model id/idAttribute is not set
				# the required data to create the model is present inside model. so model.toJSON()
				when 'create'
					params.data = _.defaults model.toJSON(), params.data
					
				# update a model. Two possible options, send entire model data to server or send 
				# only updated one. This condition will be handled with options passed along save
				# options name is ‘onlyChanged’ accepting boolean value. default to ‘true’
				when 'update'
					onlyChanged = options.onlyChanged ? false
					
					if onlyChanged
						# get all changed values and add them to param’s data attribute
						if model.hasChanged()
							params.data.changes = {}
							
							_.each model.changed, (property, index)->
								params.data.changes[ property ] = this.get property
							, @
					else
						# put all model data in params data attribute
						params.data = _.defaults model.toJSON(), params.data
				
				# deleting a model. This will need only the id of the model to send to server. Different model 
				# can have different idAttributes, hence, get the id attribute first and set it as the data attributes
				# property.
				when 'delete'
					allData = options.allData ? true
					if allData
						# put all model data in params data attribute
						params.data = _.defaults model.toJSON(), params.data
					else
						# get the model’s idAttribute. can be other then ‘id’
						idAttr = model['idAttribute']
						params.data[idAttr] = model.get idAttr
					
			# Don't process data on a non-GET request.
			# params.processData = false  if params.type isnt "GET" and not options.emulateJSON						
			
			# Make the request, allowing the user to override any Ajax options.
			xhr = options.xhr = Backbone.ajax(_.extend(params, options))
			
			# trigger the request event of the model
			model.trigger "request", model, xhr, options
	
			# attach _fetch to model
			model._fetch = xhr if method is 'read' or method is 'create'
	
			# return the xhr object. this is a jquery deffered object
			xhr
			
		# model parse function
		parse:(resp)->
			# change sizes to an array
			if resp.code is 'OK'
				console.log("response")
				console.log(resp)
				return resp.data 
	
			resp
	
	
	
	# define the menu collection
	class ActivityCollection extends Backbone.Collection
	
		model : ActivityModel
	
		initialize : (options)->
			console.log "activitycollection"
			console.log  options.options.item_id
			@item_id = options.options.item_id
			
		url : ->
			AJANSITEURL+"/api/activities?type=get&item_id="+@item_id
	
		parse :(response)->
			response.collection
		
	
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
	
	
		name : 'comment'
	
		urlRoot : AJANSITEURL+"/api/activities"
	
		sync : (method, model, options)-> 
			sendmethod = method
			if method is "create"
				sendmethod = "POST"
			# check if the name property is set for the model
			# this property is important because the “action”
			# param required for wordpress ajax is generated 
			# combining “#{method}-#{name}”
			
			if not @name
				throw new Error "'name' property not set for the model"
			
			# Default JSON-request options.
			params =
				type : sendmethod
				dataType: "json"
				data : {}
				
			# All ajax request in wordpress are sent to admin_url(‘admin-ajax.php’)
			# a global AJAXURL variable must be defined for all ajax actions
			# so, the url is always AJAXURL
			console.log model 
			if method is "delete"
			  params.url =  @urlRoot+"/"+ model.get("id")
			else
			  params.url =  @urlRoot 
			
			
			# generate the “action” param and bind it to data attribute of ‘params’
			_action = "#{method}-#{@name}"
			params.data['action'] = _action	
			
			# handle various CRUD operations depending on method name
			switch method
			
				# read a model form server. the only property read a model from server is the 
				# id attribute of the model. 
				when 'read'
					# read action must trigger a GET request. set the request to GET
					params.type = 'GET'
					
					# get the id attribute of the model
					idAttr = model['idAttribute']
					params.data[idAttr] = model.get idAttr
	
					
					
				# create a new model. At this point the model id/idAttribute is not set
				# the required data to create the model is present inside model. so model.toJSON()
				when 'create'
					params.data = _.defaults model.toJSON(), params.data
					
				# update a model. Two possible options, send entire model data to server or send 
				# only updated one. This condition will be handled with options passed along save
				# options name is ‘onlyChanged’ accepting boolean value. default to ‘true’
				when 'update'
					onlyChanged = options.onlyChanged ? false
					
					if onlyChanged
						# get all changed values and add them to param’s data attribute
						if model.hasChanged()
							params.data.changes = {}
							
							_.each model.changed, (property, index)->
								params.data.changes[ property ] = this.get property
							, @
					else
						# put all model data in params data attribute
						params.data = _.defaults model.toJSON(), params.data
				
				# deleting a model. This will need only the id of the model to send to server. Different model 
				# can have different idAttributes, hence, get the id attribute first and set it as the data attributes
				# property.
				when 'delete'
					allData = options.allData ? true
					if allData
						# put all model data in params data attribute
						params.data = _.defaults model.toJSON(), params.data
					else
						# get the model’s idAttribute. can be other then ‘id’
						idAttr = model['idAttribute']
						params.data[idAttr] = model.get idAttr
					
			# Don't process data on a non-GET request.
			# params.processData = false  if params.type isnt "GET" and not options.emulateJSON						
			
			# Make the request, allowing the user to override any Ajax options.
			xhr = options.xhr = Backbone.ajax(_.extend(params, options))
			
			# trigger the request event of the model
			model.trigger "request", model, xhr, options
	
			# attach _fetch to model
			model._fetch = xhr if method is 'read' or method is 'create'
	
			# return the xhr object. this is a jquery deffered object
			xhr
			
		# model parse function
		parse:(resp)->
			# change sizes to an array
			if resp.code is 'OK'
				console.log("response")
				console.log(resp)
				return resp.data 
	
			resp
	
		
	 
				
	# define the menu collection
	class CommentCollection extends Backbone.Collection
	
		model : CommentModel
				
		url : ->
			AJANSITEURL+"/api/activities/comments"
	
		parse :(response)->
			response.collection
					
	 
	class SingleView extends Marionette.ItemView 
					 
							
		template    : '<div class="avatar-box">
										<div class="avatar left" href="#">
												<img src="{{{NOAVATAR}}}" class="avatar-img ajan-user-pic-{{user_id}}">
										</div>
										<div class="avatar-content activity-main-{{id}}">
												<h5 class="avatar-heading left">{{{action}}} </h5>
												<h5 class="avatar-heading left full-width">
												<small class="ajan-user-name ajan-user-name-{{user_id}}"> Minyawn</small>
												<small class="ajan-user-role ajan-user-role-{{user_id}}"></small>
												<small class="ajan-user-additional-info-{{user_id}}"></small></h5>
												 
												<p class="comment m-tb-5">{{content}}</p>
	
												<div class="comment-info m-b-10">
														<span class="comment-date left">
																{{activity_date}}
														</span>
														<span class="left">&nbsp;|&nbsp;</span>
														<span class="comment-time left">
														{{activity_time}}
														</span>
	
														<span class="right rep-del">
																<a href="javascript:void(0)" class="reply get-comments" activity="{{id}}">
																		comments({{comment_count}})
																</a>&nbsp;
																<a href="javascript:void(0)" class="reply reply-activity reply-activity-{{id}}"    activity="{{id}}">
																		<span class="glyphicon glyphicon-share-alt reply-activity reply-activity-{{id}}" activity="{{id}}"></span>
																</a>&nbsp;
																<a href="javascript:void(0)" class="delete">
																		<span class="glyphicon glyphicon-trash delete-activity delete-activity-{{id}}" activity="{{id}}" ></span>
																</a>
	
														</span>
														<div class="reply-txt reply-txt-{{id}}">
														<p class="reply-msg left">Enter your Reply here</p><br>
														<textarea class="full m-tb-10" name="activity-comment-{{id}}" id="activity-comment-{{id}}" rows="2"></textarea>
														<div class="right m-b-10">
																<input type="button" class="btn green-btn save-activity-reply" id="save-activity-reply-{{id}}" value="Post Reply"  activity="{{id}}">
																<input type="button" class="btn cancel-activity-reply" value="Cancel"  activity="{{id}}">
														</div>
													</div>
												</div>
	
								 
											</div>
											
									 
	
									</div>
									'
	
		mixinTemplateHelpers:(data)->
			data.NOAVATAR = NOAVATAR
			activity_date = data.date_recorded
			date_recorded = data.date_recorded.split(" ")
			date_recorded_date = date_recorded[0]
			date_recorded_time = date_recorded[1]
			activity_date = moment(date_recorded_date) 
			data.activity_date = activity_date.format("MMM Do YY");
			data.activity_time = date_recorded_time;  
	
			data
	
							
					 
	
	class ShowPackage extends Marionette.CompositeView
	 
		initialize : (options)->
	
	
		template : '<div class="msg-cover">
												 
									        <div class="right">
									          Show: <select name="activity_filter" id="activity_filter" class="select-filter">
									            <option value="">Everything</option>
									          </select>
									        </div>
									    		<p class="msg left" style="clear: both;">Enter your Message here</p>
									    		<textarea class="full m-b-10 clearfix" rows="3" name="content" id="activity_content"></textarea>
									    		<div class="right m-b-10">
									      		<input type="submit" id="ajan-post-activity" class="btn green-btn" value="Post Message">
									    		</div> 
											
	
									  		<div class="avatar-container" id="activity_container">
									      
									      </div> 
									</div>'
	
		childView  : SingleView
	
		childViewContainer : '#activity_container' 
	 
		events  :
			'click #ajan-post-activity':(e)->
									e.preventDefault()  
									if $("#activity_content").val()==""
										$("#activity_content").after("<span class='error-message'>Mesage cannot be empty</span>")
									else
										data = {content:$("#activity_content").val()}
										$(e.target).parent().parent().append('<span class="right throbber-container"><span class="throbber"></span></span>')
										$(e.target).hide()
										@trigger "save:new:activity" , data
	
			'click .reply-activity' :(e)-> 
									$('.reply-txt-'+$(e.target).attr('activity')).show()
									$('.reply-activity-'+$(e.target).attr('activity')).hide()
	
			'click .cancel-activity-reply':(e)-> 
									$('.reply-activity-'+$(e.target).attr('activity')).show()
	
									$('.reply-txt-'+$(e.target).attr('activity')).hide()
	
			'click .save-activity-reply':(e)->
									if $('#activity-comment-'+$(e.target).attr('activity')).val()==""
										$('#activity-comment-'+$(e.target).attr('activity')).after("<span class='error-message'>Mesage cannot be empty</span>")
									else  
										data = {content:$('#activity-comment-'+$(e.target).attr('activity')).val(),secondary_item_id:$(e.target).attr('activity')}
										$(e.target).parent().parent().append('<span class="right throbber-container"><span class="throbber"></span></span>')
										$(e.target).next().hide()
										$(e.target).hide()
									
										@trigger "save:new:comment" , data
	
			'click .delete-activity':(e)->
									check = confirm('Are you sure you want to delete this activity?')
									if check == true
										$('.delete-activity-'+$(e.target).attr('activity')).parent().parent().append('<span class="throbber"></span>')
										$('.delete-activity-'+$(e.target).attr('activity')).parent().hide()
										@trigger "delete:activity" , $(e.target).attr('activity')
	
			'click .delete-comment':(e)->
									check = confirm('Are you sure you want to delete this activity comment?')
									if check == true 
										$('.delete-comment-'+$(e.target).attr('activity')).parent().append('<span class="throbber"></span>')
										$(e.target).parent().hide()
										console.log "delete-comment"
										@trigger "delete:comment" , $(e.target).attr('activity')
	
			'click .get-comments':(e)-> 
									@trigger "fetch:all:comments" ,$(e.target).attr('activity')
	
			'click #activity_filter' : (e)->
									@trigger "create:filters" ,$(e.target).val()
	
			'change #activity_filter':(e)-> 
									console.log "change activity-filter"
									@trigger "filter:activity" ,$(e.target).val()
	
		onRender:(collection)->    
			@trigger "get:user:info"
			@trigger "fetch:latest:comments"
	
		onShow:()->
			console.log "showing" 
	
		collectionEvents:
			'reset': 'collectionReset'
	
		collectionReset:(model)-> 
			@trigger "get:user:info" 
	 
	
		onAddedActivityModel : ()-> 
			$("#ajan-post-activity").show()
			$("#ajan-post-activity").parent().parent().find(".throbber-container").remove()
			$("#activity_content").val("") 
			$("#activity_filter").trigger('change') 
			@trigger "get:user:info" 
	
		onChangeUserImage : (n)->
			_.each n.models, (model) -> 
				$(".ajan-user-pic-" + model.get("ID")).attr "src", model.get("profile_pic")
				$(".ajan-user-role-" + model.get("ID")).html model.get("user_role")
				$(".ajan-user-name-" + model.get("ID")).html model.get("name")
				unless model.get("additional_info") is "" 
					$(".ajan-user-additional-info-" + model.get("ID")).addClass "ajan-user-additional-info"
					$(".ajan-user-additional-info-" + model.get("ID")).html model.get("additional_info")
	 
									
			return
	
		onAddedCommentModel : (model)->  
			$("#save-activity-reply-"+model.get("secondary_item_id")).show()
			$("#save-activity-reply-"+model.get("secondary_item_id")).next().show()
			$("#save-activity-reply-"+model.get("secondary_item_id")).parent().parent().find(".throbber-container").remove()
			$("#save-activity-reply-"+model.get("secondary_item_id")).next().trigger('click')        
			$("#activity-comment-"+model.get("secondary_item_id")).val("")
			activity_date = model.get("date_recorded")
			date_recorded = activity_date.split(" ")
			date_recorded_date = date_recorded[0]
			date_recorded_time = date_recorded[1]
			activity_date = moment(date_recorded_date) 
			activity_date =activity_date.format("MMM Do YY");
			activity_time =date_recorded_time; 
			$(".activity-main-"+model.get("secondary_item_id") ).append('<div class="avatar-box-1" id="activity-comment-container-'+model.get("id")+'">
												<div class="avatar left" href="#">
														<img src="'+NOAVATAR+'" class="avatar-img ajan-user-pic-'+model.get("user_id")+'">
												</div>
												<div class="avatar-content">
														<h5 class="avatar-heading left">'+model.get("action")+'</h5>
														<p class="comment m-tb-5">'+model.get("content")+'</p>
															<div class="comment-info m-b-10">
																<span class="comment-date left">
																'+activity_date+'
																</span>
																<span class="left">&nbsp;|&nbsp;</span>
																<span class="comment-time left">
																 '+activity_time+'
																</span>
																<span class="right rep-del">
																				
																				<a href="javascript:void(0)" class="delete delete-comment-'+model.get("id")+'" activity="'+model.get("id")+'">
																						<span class="glyphicon glyphicon-trash delete-comment delete-comment-'+model.get("id")+'" activity="'+model.get("id")+'"></span>
																				</a>
																		</span>
																</div>
														</div>
												</div>')
			@trigger "get:user:info"  
	
		onActivityCommentsFetched : (activity_comments,activity)-> 
			$(".activity-main-"+activity).find('.avatar-box-1').remove()
			_.each activity_comments.models, (model) -> 
				activity_date = model.get("date_recorded")
				date_recorded = activity_date.split(" ")
				date_recorded_date = date_recorded[0]
				date_recorded_time = date_recorded[1]
				activity_date = moment(date_recorded_date) 
				activity_date =activity_date.format("MMM Do YY");
				activity_time =date_recorded_time; 
				$(".activity-main-"+model.get("secondary_item_id") ).append('<div class="avatar-box-1" id="activity-comment-container-'+model.get("id")+'">
											<div class="avatar left" href="#">
													<img src="'+NOAVATAR+'" class="avatar-img ajan-user-pic-'+model.get("user_id")+'">
											</div>
											<div class="avatar-content">
													<h5 class="avatar-heading left">'+model.get("action")+'</h5>
													<p class="comment m-tb-5">'+model.get("content")+'</p>
														<div class="comment-info m-b-10">
															<span class="comment-date left">
															'+activity_date+'
															</span>
															<span class="left">&nbsp;|&nbsp;</span>
															<span class="comment-time left">
															 '+activity_time+'
															</span>
															<span class="right rep-del">
																			
																			<a href="javascript:void(0)" class="delete  delete-comment-'+model.get("id")+'" activity="'+model.get("id")+'">
																					<span class="glyphicon glyphicon-trash delete-comment delete-comment-'+model.get("id")+'" activity="'+model.get("id")+'"></span>
																			</a>
																	</span>
															</div>
													</div>
											</div>')
	
			@trigger "get:user:info"  
	
		onActivityCommentDeleted:(activity)-> 
			$('#activity-comment-container-'+activity).remove()
	
		onGenerateFilters:(activityFilters)->
			$("#activity_filter").empty()
			console.log "activityFilters"
			console.log activityFilters
			_.each activityFilters, (val) -> 
				console.log "val"+val
				displayVal = val.replace("_"," ")
				displayVal =   displayVal.charAt(0).toUpperCase() + displayVal.slice(1);
				$("#activity_filter").append new Option(displayVal, val)
	
							
	
		onTriggerActivityFilter:()->  
			@trigger "filter:activity" ,$("#activity_filter").val() 
	class ActivityStreamCtrl extends Marionette.Controller
	
	
	
		initialize  :(options)->
			@options = options
	
			@currentActivityCollection = new ActivityCollection(options)
	
			@activityCollection = new ActivityCollection(options)
	
			@userCollection = new UserCollection(options)
	
			@commentCollection = new CommentCollection(options)
	
			@view = view = @_getView @activityCollection 
			console.log "activity stream controllen init"
			console.log options
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
			console.log("showview")
			console.log(@options.region)
			@options.region.show @view
	
		_getView: (activityCollection) -> 
			new ShowPackage
				collection :  activityCollection
	
		_getUsers:() -> 
			console.log "activityCollection"
			console.log @activityCollection
			console.log "currentActivityCollection"
			console.log @currentActivityCollection
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
	
		_createFilters:() ->
			componentType = _.uniq(@activityCollection.pluck("type"));
			console.log "componentType"
			console.log componentType
			@view.triggerMethod "generate:filters" , componentType
	
	
		_saveActivity:(data)-> 
			data.item_id = @options.options.item_id
			console.log data
			console.log "controller save activity" 
			activityModel = new ActivityModel data
			console.log (activityModel)
			activityModel.save null,
				emulateJSON : true, 
				wait: true
				success : @_activityAdded
	
		_saveComment:(data)->
			data.item_id = @options.options.item_id
			console.log "controller save comment" 
			commentModel = new CommentModel(data)
			commentModel.save null,
							emulateJSON : true, 
							wait: true
							success : @_commentAdded
	
		_activityAdded :(model,response)=>
			console.log "controller added activity"
			@activityCollection.unshift model 
			console.log @activityCollection
			#now App.execute "add:new:activity:model", model
			@view.triggerMethod "added:activity:model"
			
	
		_commentAdded :(model,response)=>
			console.log "controller added comment"
			@commentCollection.add model 
			console.log @commentCollection
			#now App.execute "add:new:comment:model", model
			@view.triggerMethod "added:comment:model" , model
	
		_getLatestComments:-> 
			console.log "get latest comments"
			activity_ids = @activityCollection.pluck("id"); 
			activity_ids = activity_ids.join() 
			#now @commentCollection = new App.Entities.Comment.CommentCollection
			@commentCollection.fetch   
				data:
					activity_parent : activity_ids
					item_id : @options.item_id
					records : 3
				success: (collection, response)=>
					@view.triggerMethod "activity:comments:fetched" , collection
	
		_getAllComments:(activity)->
			console.log "get All comments" 
			#now @commentCollection = new App.Entities.Comment.CommentCollection
			@commentCollection.fetch   
				data:
					activity_parent : activity
					item_id : ajan_item_id
					records : ''
				success: (collection, response)=>
					console.log collection.length
					@view.triggerMethod "activity:comments:fetched" , collection, activity
	
	
		_deleteActivity:(activity)->  
			model =  @activityCollection.get activity 
			model.destroy
				success: (status, response)=>
					console.log "status"
					@currentActivityCollection.remove(model)
	
	
		_deleteComment:(activity)->  
			console.log "_deleteComment"
			console.log @commentCollection
			model =  @commentCollection.get activity 
			model.destroy
				success: (status, response)=>
					console.log "status"
					@view.triggerMethod "activity:comment:deleted" , activity
	
		_filterActivity:(filterBy)->   
			console.log  "filtering"
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
	
	
	class AjActivityStreamModule extends Marionette.Module
	
		initialize : (options = {})->
			super options
	

	AjActivityStreamModule
