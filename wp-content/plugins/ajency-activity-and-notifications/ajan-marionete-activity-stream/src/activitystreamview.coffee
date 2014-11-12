class SingleView extends Marionette.ItemView 
				 
						
	template    : '<div class="avatar-box">
									<div class="avatar left" href="#">
											<img src="{{{NOAVATAR}}}" class="avatar-img ajan-user-pic-{{user_id}}">
									</div>
									<div class="avatar-content activity-main-{{id}}">
											<h5 class="avatar-heading left">{{{action}}} </h5>
											 <div class="comment-info m-b-10">
                          <div class="comment-date-right">
                          <span class="comment-date right">
                              {{activity_date}}
                          </span>
                          <span class="right">&nbsp;,&nbsp;</span>
                          <span class="comment-time right">
                          		{{activity_time}}
                          </span>
                          </div>
                    </div>
											<h5 class="avatar-heading left full-width">
											<small class="ajan-user-name ajan-user-name-{{user_id}}"> Minyawn</small>
											<small class="ajan-user-role ajan-user-role-{{user_id}}"></small>
											<small class="ajan-user-additional-info-{{user_id}}"></small></h5>
											 
											<p class="comment m-tb-5">{{content}}</p>

											<div class="comment-info m-b-10">
												<div class="comment-date-left">
													<span class="comment-date left">
															{{activity_date}}
													</span>
													<span class="left">&nbsp;|&nbsp;</span>
													<span class="comment-time left">
													{{activity_time}}
													</span>
												</div>
												<div class="activity-comment-actions-left">  
 												<span class="left rep-del">
                        <a href="javascript:void(0)" class="reply get-comments" activity="{{id}}">
                                  comments(<span id="comment_count_{{id}}">{{comment_count}}</span>)
                              |</a>
                              <a href="javascript:void(0)" class="reply reply-activity reply-activity-{{id}}"  activity="{{id}}">
                                  reply
                              |</a>
                              <a href="javascript:void(0)" class="delete delete-activity delete-activity-{{id}}" activity="{{id}}">
                                  delete
                              </a>

                          </span>
                         </div>
                        <div class="activity-comment-actions-right">  
													<span class="right rep-del">
															<a href="javascript:void(0)" class="reply get-comments" activity="{{id}}">
																	comments(<span id="comment_count_{{id}}">{{comment_count}}</span>)
															</a>&nbsp;
															<a href="javascript:void(0)" class="reply reply-activity reply-activity-{{id}}"    activity="{{id}}">
																	<span class="glyphicon glyphicon-share-alt reply-activity reply-activity-{{id}}" activity="{{id}}"></span>
															</a>&nbsp;
															<a href="javascript:void(0)" class="delete">
																	<span class="glyphicon glyphicon-trash delete-activity delete-activity-{{id}}" activity="{{id}}" ></span>
															</a>

													</span>
													</div>
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
	modelEvents:
		'change': 'modelChanged'

	modelChanged:(model)->
		console.log "modellllll"
		console.log model

		console.log "#comment_count_"+model.get("id")
		$("#comment_count_"+model.get("id")).html(model.get("comment_count"))
						
				 

class ShowPackage extends Marionette.CompositeView
 
	initialize : (options)->


	template : '<div class="msg-cover">
											 
								        <div class="right">
								          Show: <select name="activity_filter" id="activity_filter" class="select-filter">
								            <option value="">Everything</option>
								          </select>
								        </div>
								    		<p class="msg left" >Enter your Message here</p><br>
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
									 
									alert("Mesage cannot be empty")
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
									@trigger "delete:comment" , $(e.target).attr('activity')

		'click .get-comments':(e)-> 
								@trigger "fetch:all:comments" ,$(e.target).attr('activity')

		'focus #activity_filter' : (e)->
								@trigger "create:filters" ,$(e.target).val()

		'change #activity_filter':(e)-> 
								@trigger "filter:activity" ,$(e.target).val()

	onRender:(collection)->    
		@trigger "get:user:info"
		@trigger "fetch:latest:comments"

	onShow:()->

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
														<div class="comment-info m-b-10">
														<div class="comment-date-right">
                          <span class="comment-date right">
															'+activity_date+'
															</span>
															<span class="right">,</span>
															<span class="comment-time right">
															 '+activity_time+'
															</span>
                          </div>
                          </div>
													<p class="comment m-tb-5">'+model.get("content")+'</p>
														<div class="comment-info m-b-10">
															<div class="comment-date-left">
															<span class="comment-date left">
															'+activity_date+'
															</span>
															<span class="left">&nbsp;|&nbsp;</span>
															<span class="comment-time left">
															 '+activity_time+'
															</span>
															</div>
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
		console.log "onActivityCommentsFetched"
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
													<div class="comment-info m-b-10">
														<div class="comment-date-right">
                          <span class="comment-date right">
															'+activity_date+'
															</span>
															<span class="right">,</span>
															<span class="comment-time right">
															 '+activity_time+'
															</span>
                          </div>
                          </div>
												<p class="comment m-tb-5">'+model.get("content")+'</p>
													<div class="comment-info m-b-10">
														<div class="comment-date-left">
														<span class="comment-date left">
														'+activity_date+'
														</span>
														<span class="left">&nbsp;|&nbsp;</span>
														<span class="comment-time left">
														 '+activity_time+'
														</span>
														 </div>
														 	<div class="activity-comment-actions-left">  
 															<span class="left rep-del">
                      
                              <a href="javascript:void(0)" class="delete delete-comment delete-comment-'+model.get("id")+'" activity="'+model.get("id")+'">
                                  delete
                              </a>

                          </span>
                         </div>
                         <div class="activity-comment-actions-right">  
														<span class="right rep-del">
																		
																		<a href="javascript:void(0)" class="delete  delete-comment-'+model.get("id")+'" activity="'+model.get("id")+'">
																				<span class="glyphicon glyphicon-trash delete-comment delete-comment-'+model.get("id")+'" activity="'+model.get("id")+'"></span>
																		</a>
																</span>
													</div>
														</div>
												</div>
										</div>')

		@trigger "get:user:info"  

	onActivityCommentDeleted:(activity)-> 
		$('#activity-comment-container-'+activity).remove()

	onGenerateFilters:(activityFilters,selectedFilter)->
		$("#activity_filter").empty()
		$('#lstCities option[value!="'+selectedFilter+'"]').remove();
		$("#activity_filter").append new Option("Everything", "")
		_.each activityFilters, (val) -> 
			displayVal = val.replace("_"," ")
			displayVal =   displayVal.charAt(0).toUpperCase() + displayVal.slice(1);
			$("#activity_filter").append new Option(displayVal, val)

						

	onTriggerActivityFilter:()->  
		@trigger "filter:activity" ,$("#activity_filter").val() 