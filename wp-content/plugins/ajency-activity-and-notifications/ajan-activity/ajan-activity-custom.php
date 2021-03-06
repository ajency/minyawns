<?php

/**
 * Allow core components and dependent plugins to register activity actions.
 *
 * @since ajency-activity-and-notifications (1.2)
 *
 * @uses do_action() To call 'ajan_register_activity_actions' hook.
 */
function ajan_register_custom_activity_actions() {
 
	do_action( 'ajan_set_activity_action' );

}
add_action( 'ajan_init', 'ajan_register_custom_activity_actions', 12 );


/**
 * Register the activity stream actions for updates
 *
 * @since ajency-activity-and-notifications (1.6)
 *
 * @global object $ajan BuddyPress global settings.
 */
function ajan_set_activity_action() {
	 
	global $ajan;

	$theme_activity_actions = apply_filters('ajan_register_theme_activity_actions',array());
 
 	$plugin_activity_actions = apply_filters('ajan_register_plugin_activity_actions',array());
 
 	$activity_actions = array_merge($theme_activity_actions,$plugin_activity_actions);

	foreach($activity_actions as $activity_action){
			ajan_activity_set_action($activity_action['component_id'], 
			$activity_action['type'],
			$activity_action['description'],
			$activity_action['format_callback'] 
		); 
	}

}
add_action( 'ajan_set_activity_action', 'ajan_set_activity_action' );


/**
 * return the activity collections called on ajan_has_activities filter hook
 *
 * @since ajency-activity-and-notifications (0.1.0)
 * @return $activities_template the activity collection array or false if no activities are found 
 */
function ajan_has_activities_return($has_activities, $activities_template, $template_args){
 
 	$activities = array();
 	if($has_activities){
 		foreach($activities_template->activities as $activities_template_activity)
 		{
 			$children = array();
 			 
 			$comment_count = count(AJAN_Activity_Activity::get_child_comments($activities_template_activity->id));
 
 			$activities_template_activity->comment_count = $comment_count;
 			$activities[] = custom_resturn_fields($activities_template_activity);

 		}
 	
		return $activities;
 	}else{
 		return $has_activities; //if activities are not present return false
 	}
	
}




/**
 * return child count for parent
 *
 */
function child_count_for_parent($parentid){
	$child = ajan_get_activities($args=array('secondary_id'=>$parentid));
	if ($child!=false){
		return count($child);
	}else{
		return 0;
	}
}



/**
 * return only required fields of activity
 *
 */

function custom_resturn_fields($activities_template_activity){
	$children = array();
	if($activities_template_activity->children!=false){

		foreach($activities_template_activity->children as $activity_children){
			$children[] = custom_resturn_fields($activity_children);
		}
		
	}

	
	return 	array(	'id'=>$activities_template_activity->id,
				 	'user_id'			=>$activities_template_activity->user_id,
				 	'component'			=>$activities_template_activity->component,
				 	'type'				=>$activities_template_activity->type,
				 	'action'			=>$activities_template_activity->action,
				 	'content'			=>$activities_template_activity->content,
				 	'item_id'			=>$activities_template_activity->item_id,
				 	'secondary_item_id'	=>$activities_template_activity->secondary_item_id,
				 	'date_recorded'		=>$activities_template_activity->date_recorded,
				 	//'hide_sitewide'		=>$activities_template_activity->hide_sitewide,
				 	//'children'			=>$children,
				 	'comment_count'		=>$activities_template_activity->comment_count,

			 		);
}

/**
 * get user specific activities
 *
 * @since ajency-activity-and-notifications (0.1.0)
 * @uses ajan_has_activities() to get activities.
 * @uses ajan_has_activities filter hook to return the as it is
 * @param $user_id the users whose activities need to be returned, 
 * if not passed the logged in users activites are returned
 * @param $page which page /offset to return
 * @param $per_page no of activites per page
 * if either  $page or $per_page activites are not paginated
 */

function ajan_get_user_personal_activities($args){

	global $user_ID;
	$defaults = array( 
		'user_id'			=> $user_ID,     // user_id to filter on 
		'show_hidden'		=> true,
		'display_comments'  => 'threaded',
		'component'			=> false,
		'action'			=> false,
		'page'				=> '',
		'per_page'			=> '',
		 
	);
 
	$args = wp_parse_args( $args, $defaults );

	//in the plugin get function the component is refered as object
	$args['object'] = $args['component'];

	unset($args['component']);

	add_filter('ajan_has_activities','ajan_has_activities_return',10,3);

    return ajan_has_activities($args) ;

 }











 function ajan_get_activities($args){

	
	/*$defaults = array( 
		// 'primary_id'			=> '2428',
		'object'			=> 'job',
		//'offset'				=> '1',
		'max'			=> '1',
		 'secondary_id'			=> '0',
		);
 
	$args = wp_parse_args( $args, $defaults );*/

	
	add_filter('ajan_has_activities','ajan_has_activities_return',10,3);

    return ajan_has_activities($args) ;

 }


function ajan_get_activity_comments($args){

 		$activity_comments = array();
 		$activity_parents = explode(",", $args['activity_parent']);
 		foreach($activity_parents as $activity_parent){
 	 		$activities_ids = array();
			$activities_ids_objects =   AJAN_Activity_Activity::get_child_comments($activity_parent);
	 		foreach($activities_ids_objects as $activities_ids_object){
	 			$activities_ids[] = intval($activities_ids_object->id);
	 		}
			  
			  if(count($activities_ids)){
			  		add_filter('ajan_has_activities','ajan_has_activities_return',10,3);
 						$args['in'] = $activities_ids;
 						$args['display_comments'] = true; 
 			 
    				$activity_comments = array_merge($activity_comments,ajan_has_activities($args));
			  }
 				
 		}
 		return $activity_comments;
}

 /**
 * get activities where the user has been mentioned,
 *
 * @since ajency-activity-and-notifications (0.1.0)
 * @uses ajan_has_activities() to get activities.
 * @uses ajan_has_activities filter hook to return the as it is
 * @param $user_id the user id of the user who is mentioned in activites, 
 * if not passed the logged in users activites are returned
 * @param $page which page /offset to return
 * @param $per_page no of activites per page
 * if either  $page or $per_page activites are not paginated
 */

function ajan_get_user_mentions_activities($args){
	global $user_ID; 
	$defaults = array( 
		'user_id'			=> $user_ID,     // user_id to filter on 
		'scope'             => 'mentions',     // user_id to filter on
		'show_hidden'		=> true,
		'display_comments'  => 'threaded',
		'component'			=> false,
		'action'			=> false,
		'page'				=> '',
		'per_page'			=> '',
		 
	);
 
	$args = wp_parse_args( $args, $defaults );

	//in the plugin get function the component is refered as object
	$args['object'] = $args['component'];

	unset($args['component']);

	 
	add_filter('ajan_has_activities','ajan_has_activities_return',10,3);

    return ajan_has_activities($args) ;

 }



 /**
 * get activities which the user has marked as favorite,
 *
 * @since ajency-activity-and-notifications (0.1.0)
 * @uses ajan_has_activities() to get activities.
 * @uses ajan_has_activities filter hook to return the as it is
 * @param $user_id the user id of the user whose favorite activites have tobe returned, 
 * if not passed the logged in users activites are returned
 * @param $page which page /offset to return
 * @param $per_page no of activites per page
 * if either  $page or $per_page activites are not paginated
 */

function ajan_get_user_favorite_activities($user_id=0,$page='',$per_page=''){

	global $user_ID; 
	$defaults = array( 
		'user_id'			=> $user_ID,     // user_id to filter on 
		'scope'             => 'favorites',     // user_id to filter on
		'show_hidden'		=> true,
		'display_comments'  => 'threaded',
		'component'			=> false,
		'action'			=> false,
		'page'				=> '',
		'per_page'			=> '',
		 
	);
 
	$args = wp_parse_args( $args, $defaults );
	 
	add_filter('ajan_has_activities','ajan_has_activities_return',10,3);

    return ajan_has_activities($args) ;

 }

  /**
 * get activities across the site
 *
 * @since ajency-activity-and-notifications (0.1.0)
 * @uses ajan_has_activities() to get activities.
 * @uses ajan_has_activities filter hook to return the as it is   
 * @param $page which page /offset to return
 * @param $per_page no of activites per page
 * if either  $page or $per_page activites are not paginated
 */

function ajan_get_site_wide_activities($page='',$per_page=''){
 
	$defaults = array(  
		'scope'             => 'favorites',     // user_id to filter on
		'show_hidden'		=> true,
		'display_comments'  => 'threaded',
		'component'			=> false,
		'action'			=> false,
		'page'				=> '',
		'per_page'			=> '',
		 
	);
	 
 

	add_filter('ajan_has_activities','ajan_has_activities_return',10,3);

    return ajan_has_activities($args) ;

 }

  /**
 * get activity by activity id
 *
 * @since ajency-activity-and-notifications (0.1.0)
 * @uses ajan_has_activities() to get activities.
 * @uses ajan_has_activities filter hook to return the as it is
 * @param $activity_id the activity id of the activity  to be returned  
 */

function ajan_get_activity_by_id($activity_id=0){

	//if no user_id is passed then get the current logged in user id and return his activities
	if($user_id==0){

		global $user_ID;

		$user_id = $user_ID;

	}
	$args = array( 
		// Filtering
		'in'           => array($activity_id) ,   // user_id to filter on 
		'display_comments'  => 'stream', 
		 
	);

	add_filter('ajan_has_activities','ajan_has_activities_return',10,3);
	$activity = ajan_has_activities($args);
 	if($activity!=false){
 		return $activity[0] ;
 	}else{
 		return $activity;
 	}
    

 }


 /**
 * get all components
 *
 * @since ajency-activity-and-notifications (0.1.0)  
 */
 
function ajan_activity_get_components() {
	$components  = array();

	// Walk through the registered actions, and build an array of actions/values.

	foreach ( activitynotifications()->activity->actions as $action_key => $action ) {
		  
			$components[] = $action_key;
	}
   return $components;
}


 /**
 * delete activity by id
 *
 * @since ajency-activity-and-notifications (0.1.0)  
 */
 
function ajan_activity_delete_by_id($id){

	return ajan_activity_delete(array('id'=>$id));
	
}



//Function to get user profile image
function get_activity_user_profile_pic($id){
	$profile_pic = apply_filters( 'activity_user_profile_pic', $id );
  
	if($profile_pic == $id || $profile_pic==""){
		$profile_pic = activitynotifications()->plugin_url. "interface/img/non-avatar.jpg";
	}
	return $profile_pic;
}

//Function to get user profile url
function get_activity_user_profile_url($id){
	$profile_url = apply_filters( 'activity_user_profile_url', $id );
	if($profile_url == $id){
		$profile_url = get_author_posts_url($id);
	}
	return $profile_url;
}
 
//Function to get user display name
function get_activity_user_display_name($id){
	$display_name = apply_filters( 'activity_user_display_name', $id );
 
	return $display_name;
}

//Function to get user profile url
function get_activity_user_additional_info($id){
	$additional_info = apply_filters( 'activity_user_additional_info', $id );
	if($additional_info == $id){
		$additional_info = '';
	}
	return $additional_info;
}


//Function to get user profile url
function get_activity_user_role($id){
	$user_role = apply_filters( 'activity_user_role', $id );
	if($user_role == $id){
		$user_role = '';
	}
	return $user_role;
}