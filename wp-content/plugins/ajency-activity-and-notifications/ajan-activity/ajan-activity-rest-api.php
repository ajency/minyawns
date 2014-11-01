<?php


function activate_activity_rest_api(){

include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
//json rest api


	if(is_plugin_active('json-rest-api/plugin.php')){


	/**
		 * plugin api calls class
		 *
		 * @since ajency-activity-and-notifications (0.1)
		 *
		 * @uses json rest api plugin action hook wp_json_server_before_serve
		 */
		function ajan_activity_api_init() {
				global $user_ID; 
			 
				global $ajan_api_activity;

				$ajan_api_activity = new AJAN_API_Activity($user_ID);

				add_filter( 'json_endpoints', array( $ajan_api_activity, 'register_routes' ) );
		}

		add_action( 'wp_json_server_before_serve', 'ajan_activity_api_init' );

		/**
		 * Extended class defining api cals for activites
		 *
		 * @since ajency-activity-and-notifications (0.1)
		 * 
		 */
		class AJAN_API_Activity {

			protected $user_id;
			
			public function __construct( $user_id = false ) {
				   $this->user_id = $user_id ;
				}

			public function register_routes( $routes ) {
			$routes['/activity/create'] = array(
				array( array( $this, 'add_activity'), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
			);
			$routes['/activity/delete/(?P<id>\d+)'] = array(
				 array( array( $this, 'delete_activity'), WP_JSON_Server::DELETABLE)
				
			);
 			$routes['/activity/update/(?P<id>\d+)'] = array(
				 array( array( $this, 'update_activity'),      WP_JSON_Server::EDITABLE | WP_JSON_Server::ACCEPT_JSON ),
				
			);
			$routes['/comment/create'] = array(
				array( array( $this, 'add_comment'), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
			);
			$routes['/activities/me'] = array(
				//returns the collection of logged in user activities
				array( array( $this, 'get_logged_in_user_activities'), WP_JSON_Server::READABLE ),	 
			);
			$routes['/activities/user/(?P<id>\d+)'] = array(
				//returns the activities of a user ; user_id should the id of the user whose activites are required
				array( array( $this, 'get_user_activities'), WP_JSON_Server::READABLE ),	 
			);







			$routes['/activities'] = array(
				array( array( $this, 'get_activities'), WP_JSON_Server::READABLE ),
				array( array( $this, 'create_get_activities'), WP_JSON_Server::CREATABLE ),	 
				array( array( $this, 'get_update_delete_activities'), WP_JSON_Server::DELETABLE ),	 
			);

			$routes['/activities/comments'] = array(
				array( array( $this, 'get_activitycomments'), WP_JSON_Server::READABLE ),  
			);

			$routes['/activities/(?P<activityid>\d+)'] = array(
				array( array( $this, 'get_update_delete_activities'), WP_JSON_Server::READABLE ),	 
			);

			$routes['/users'] = array(
				array( array( $this, 'get_activity_users'), WP_JSON_Server::READABLE ),	 
			);




			return $routes;
		}




		function get_activities(){
 
				//diana	if(!isset($_REQUEST['nonce'])){
					//diana	$response = array('status'=>'failed','error'=>'Invalid request');
					//diana}else{
					if(isset($_REQUEST['component']) && $_REQUEST['component'] != ''){
						$args['object'] = $_REQUEST['component'];
					}
					if(isset($_REQUEST['item_id']) && $_REQUEST['item_id'] != ''){
						$args['primary_id'] = $_REQUEST['item_id'];
					}
					if(isset($_REQUEST['offset']) && $_REQUEST['offset'] != ''){
						$args['offset'] = $_REQUEST['offset'];
					}
					if(isset($_REQUEST['records']) && $_REQUEST['records'] != ''){
						$args['max'] = $_REQUEST['records'];
					}
					if(isset($_REQUEST['activity_parent']) && $_REQUEST['activity_parent'] != ''){
						$args['secondary_id'] = $_REQUEST['activity_parent'];
					}
					 	$args['sort'] = 'ASC';
				 
				 		$args['per_page'] = '';
 						
					$data = ajan_get_activities($args);

					if($data){
						$response = array('status'=>'success','collection'=>$data);
					}else{
						$response = array('status'=>'failed','error'=>'No data found');
					}

				//diana}

			 

			//Encode with json and print response
			 wp_send_json($response); 

		}

function get_activitycomments(){
 
		 
					if(isset($_REQUEST['item_id']) && $_REQUEST['item_id'] != ''){
						$args['primary_id'] = $_REQUEST['item_id'];
					}
					if(isset($_REQUEST['records']) && $_REQUEST['records'] != ''){
						$args['max'] = $_REQUEST['records'];
					}
				 
					if(isset($_REQUEST['activity_parent']) && $_REQUEST['activity_parent'] != ''){
						$args['activity_parent'] = $_REQUEST['activity_parent'];
					}
					 	$args['sort'] = 'ASC';
				 
 						
					$data = ajan_get_activity_comments($args);

					if($data){
						$response = array('status'=>'success','collection'=>$data);
					}else{
						$response = array('status'=>'failed','error'=>'No data found');
					}

				//diana}

			 

			//Encode with json and print response
			 wp_send_json($response); 

		}

	function create_get_activities(){

			 
 
		//		if(!isset($_REQUEST['nonce']) || !wp_verify_nonce( $_REQUEST['nonce'], "ACTIVITY_NONCE_STRING")){
			//		$response = array('status'=>'failed','error'=>'Invalid requestrrrr');
		//	}else{
					$creator_user_info = get_userdata(ajan_loggedin_user_id());
 				
					if(isset($_REQUEST['secondary_item_id']) && !empty($_REQUEST['secondary_item_id'])){
						$parent = ajan_get_activity_by_id($_REQUEST['secondary_item_id']);
						$parent_user_info = get_userdata($parent['user_id']);
						$action = $creator_user_info->display_name." replied on ".$parent_user_info->display_name."'s message on <a href='". get_permalink($_REQUEST['item_id'])."'>".get_the_title( $_REQUEST['item_id'] )."</a>";
						$activity_type="activity_comment";
					}else{
						$action = $creator_user_info->display_name.' posted message on <a href="'. get_permalink($_REQUEST['item_id']).'">'.get_the_title( $_REQUEST['item_id'] ).'</a>';
						$activity_type="activity_update";
					}

					$args = array(         
						'action'            => $action,
						'component'         => 'activity',
						'type'              => $activity_type,
						'user_id'           => ajan_loggedin_user_id(),
						'item_id'           => $_REQUEST['item_id'],
						'content'           => $_REQUEST['content'],
						'secondary_item_id' => $_REQUEST['secondary_item_id']
						);
					$id = ajan_activity_add($args);


					if(!$id){
						$response = array('error');
					}else{
						$response = ajan_get_activity_by_id($id);
					}

			//	}
 

			//Encode with json and print response
			 wp_send_json($response); 

		}


		function get_update_delete_activities($activityid){
			if(isset($_REQUEST['type']) && $_REQUEST['type']=='get'){

				if(!isset($_REQUEST['nonce'])){
					$response = array('status'=>'failed','error'=>'Invalid request');
				}else{
					$data = ajan_get_activity_by_id($activityid);
					if($data){
						$response = array('status'=>'success','collection'=>$data);
					}else{
						$response = array('status'=>'failed','error'=>'No data found');
					}
				}

			}else if(isset($_REQUEST['type']) && $_REQUEST['type']=='delete'){

				if(!isset($_REQUEST['nonce'])){
					$response = array('status'=>'failed','error'=>'Invalid request');
				}else{
					//delete childrens activity if any
					ajan_activity_delete( array( 'secondary_item_id' => $activityid) );

				//delete main item
					if(ajan_activity_delete_by_activity_id($activityid)){
						$response = array('status'=>'success','message'=>'Deleted successfully');
					}else{
						$response = array('status'=>'failed','error'=>'Incorrect id or cannot be deleted');
					}
				}

			}else if(isset($_REQUEST['type']) && $_REQUEST['type']=='update'){

				if(!isset($_REQUEST['nonce'])){
					$response = array('status'=>'failed','error'=>'Invalid request');
				}else{
					$creator_user_info = get_userdata(ajan_loggedin_user_id());
					$activity                    = new AJAN_Activity_Activity( $activityid );
					$activity->content           = $_REQUEST['content'];
					$activity->action            = $creator_user_info->display_name.' updated message';
					if (!$activity->save()){
						$response = array('status'=>'failed','error'=>'Incorrent id or cannot be updated');
					}else{
						$response = array('status'=>'success','message'=>'Updated successfully');
					}
				}
				
			}

			//Encode with json and print response
			$response = json_encode( $response );

			header( "Content-Type: application/json" );

			echo $response;

			exit;
		}



		function get_update_delete_activities($activityid){
			if(isset($_REQUEST['type']) && $_REQUEST['type']=='get'){

				if(!isset($_REQUEST['nonce'])){
					$response = array('status'=>'failed','error'=>'Invalid request');
				}else{
					$data = ajan_get_activity_by_id($activityid);
					if($data){
						$response = array('status'=>'success','collection'=>$data);
					}else{
						$response = array('status'=>'failed','error'=>'No data found');
					}
				}

			}else if(isset($_REQUEST['type']) && $_REQUEST['type']=='delete'){

				if(!isset($_REQUEST['nonce'])){
					$response = array('status'=>'failed','error'=>'Invalid request');
				}else{
					//delete childrens activity if any
					ajan_activity_delete( array( 'secondary_item_id' => $activityid) );

				//delete main item
					if(ajan_activity_delete_by_activity_id($activityid)){
						$response = array('status'=>'success','message'=>'Deleted successfully');
					}else{
						$response = array('status'=>'failed','error'=>'Incorrect id or cannot be deleted');
					}
				}

			}else if(isset($_REQUEST['type']) && $_REQUEST['type']=='update'){

				if(!isset($_REQUEST['nonce'])){
					$response = array('status'=>'failed','error'=>'Invalid request');
				}else{
					$creator_user_info = get_userdata(ajan_loggedin_user_id());
					$activity                    = new AJAN_Activity_Activity( $activityid );
					$activity->content           = $_REQUEST['content'];
					$activity->action            = $creator_user_info->display_name.' updated message';
					if (!$activity->save()){
						$response = array('status'=>'failed','error'=>'Incorrent id or cannot be updated');
					}else{
						$response = array('status'=>'success','message'=>'Updated successfully');
					}
				}
				
			}

			//Encode with json and print response
			$response = json_encode( $response );

			header( "Content-Type: application/json" );

			echo $response;

			exit;
		}






		function get_activity_users(){
			//Checking if all parameters are set
			if(isset($_REQUEST['users']) ){

				$ids = explode(",", $_REQUEST['users']);

					//get user data
					$user_query = new WP_User_Query( array( 'include' => $ids ) );

					//If no empty data then loop through the array and create user array for json output
					if ( ! empty( $user_query->results ) ) {
						$users = array();
						foreach ( $user_query->results as $user ) {

							$users[] = array(
								'ID' => $user->ID,
								'name' => $user->display_name,

								//get user role (filter: activity_userrole)
								'user_role' => get_activity_user_role($user->ID),
								//get user profile pic (filter: activity_user_profile_pic)
								'profile_pic' => get_activity_user_profile_pic($user->ID),

								//get user profile link url (filter: activity_user_profile_url)
								'profile_url' => get_activity_user_profile_url($user->ID),

									//get user profile link url (filter: activity_user_profile_url)
								'additional_info' => get_activity_user_additional_info($user->ID),
								);
						}
						$response = array('status'=>'success','collection'=>$users);

					} else {
						$response = array('status'=>'failed','error'=>'No user found');
					}
				
			}else{
				$response = array('status'=>'failed','error'=>'One or more fields are empty');
			}

			//Encode with json and print collection
			$response = json_encode( $response );

			header( "Content-Type: application/json" );

			echo $response;

			exit;
		}







		function get_user_activities($id,$component=''){

				$args['user_id'] = $id;
				/*if(is_array($filter)){
					foreach($filter as $filter_key => $filter_item){
						$args[$filter_key] = $filter_item;
					}
				}*/
				if(isset($_REQUEST['component'])){
  					$component = $_REQUEST['component'];
  				}
				$args['component'] = $component;
				return ajan_get_user_personal_activities($args);
		}

		function get_logged_in_user_activities(){
			$component = "";
  				if(isset($_REQUEST['component'])){
  					$component = $_REQUEST['component'];
  				}
				return $this->get_user_activities($this->user_id,$component);

		}

		function add_activity(){
	 			
	 			global $user_ID;

	 			$activity = array();

	 			$error = array();

	 			$status = false;  

	 			if(isset($_POST["user_id"])){
	 				
	 				$activity['user_id'] = $_POST["user_id"];
	 			}

	 			if(isset($_POST["action"])){
	 				
	 				$activity['action'] = $_POST["action"];
	 			}

	 			if(isset($_POST["content"])){
	 				
	 				$activity['content'] = $_POST["content"];
	 			}

	 			if(isset($_POST["component"])){
	 				
	 				$activity['component'] = $_POST["component"];
	 			}

	 			if(isset($_POST["type"])){
	 				
	 				$activity['type'] = $_POST["type"];
	 			}
	 
	 			if(!isset($_POST["component"]) || !isset($_POST["type"]) || empty($_POST["component"]) || empty($_POST["type"])){
	 				
	 				 $error[] = "Activity component or type not set.";
	 			}   
	 			if(count($error)==0){
	  
					$response = ajan_activity_add($activity); 
					if($response !=false){

						$response = ajan_get_activity_by_id($response);
					}
					$status = true;

	 			}else{

	 				$response = $error;

	 				$status = false;


	 			}
				
				$response = array('status'=>$status,'response' => $response);

				$response = json_encode( $response );

			    header( "Content-Type: application/json" );

			    echo $response;

			    exit;

		}

		function update_activity($id){
	 			
	 			global $user_ID;

	 			$activity = array();

	 			$error = array();

	 			$status = false;  
				$id = (int) $id;

				if ( empty( $id ) ) {
					$error[] = "Invalid Activity ID";
				} 
	 				
	 			$activity['id'] = $id;
	 			 

	 			if(isset($_POST["action"])){
	 				
	 				$activity['action'] = $_POST["action"];
	 			}

	 			if(isset($_POST["content"])){
	 				
	 				$activity['content'] = $_POST["content"];
	 			}

	 			if(isset($_POST["component"])){
	 				
	 				$activity['component'] = $_POST["component"];
	 			}

	 			if(isset($_POST["type"])){
	 				
	 				$activity['type'] = $_POST["type"];
	 			}
	  
	  			
				$defaults = (array)ajan_get_activity_by_id($id);


				$activity = wp_parse_args( $activity, $defaults );
				 
	 			if(count($error)==0){
 
					$response = ajan_activity_add($activity); 

					if($response !=false){

						$response = ajan_get_activity_by_id($response);
					}
					$status = true;

	 			}else{

	 				$response = $error;

	 				$status = false;


	 			}
				
				$response = array('status'=>$status,'response' => $response);

				$response = json_encode( $response );

			    header( "Content-Type: application/json" );

			    echo $response;

			    exit;

		}
 

		function delete_activity($id){
 
			$status = ajan_activity_delete_by_id($id);
			$response = json_encode(array('status'=>$status ));

			header( "Content-Type: application/json" );

			echo $response;

			exit;

		}
		function add_comment(){
	 			
	 			global $user_ID;

	 			$comment = array();

	 			$error = array();

	 			$status = false;

	 			if(isset($_POST["user_id"])){
	 				
	 				$comment['user_id'] = $_POST["user_id"];
	 			} 
	 			if(isset($_POST["content"])){
	 				
	 				$comment['content'] = $_POST["content"];
	 			}
	 			if(isset($_POST["parent_id"])){
	 				
	 				$comment['parent_id'] = $_POST["parent_id"];
	 			}
	 			if(isset($_POST["activity_id"])){
	 				
	 				$comment['activity_id'] = $_POST["activity_id"];
	 			}
 
	 			if(count($error)==0){
	 
					$response = ajan_activity_new_comment($comment); 
					 
					if($response !=false){
						$response = ajan_get_activity_by_id($response);
					}
					
					$status = true;

	 			}else{

	 				$response = $error;

	 				$status = false;


	 			}
				
				$response = array('status'=>$status,'response' => $response);

				$response = json_encode( $response );

			    header( "Content-Type: application/json" );

			    echo $response;

			    exit;

		}
		// ...
	}


	}

}
add_action( 'ajan_init', 'activate_activity_rest_api', 13 );





