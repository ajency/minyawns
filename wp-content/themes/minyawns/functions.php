<?php
/**
 * MInyawns functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 */


//remove admin bar from front end
show_admin_bar(false);


/**
 * Child theme Path
 * @param unknown $template_dir_uri
 * @param unknown $template
 * @param unknown $theme_root_uri
 * @return string
 */
function br_template_directory_uri($template_dir_uri, $template, $theme_root_uri )
{
	return $theme_root_uri . '/minyawns';
}
add_filter('template_directory_uri','br_template_directory_uri',100,3);

wp_localize_script( 'jquery', 'global', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ,'template_directory_uri' => get_template_directory_uri()  ) );



//function to log in user
function popup_userlogin()
{
	$pd_email = $_POST['pdemail'];
	$pd_pass = $_POST['pdpass'];
	
	$user_ =  get_user_by('email', $pd_email);
	$user  =  wp_authenticate($user_->user_login , $pd_pass);
	
	if (is_wp_error($user) )
	{
		$response = array('success' => false,'user'=>$user_->user_login.$pd_pass );
		wp_send_json($response);
	}
	else
	{
		wp_set_auth_cookie($user->ID);
	
		$user_data = array(
				"user_id" 	 => $user->ID,
				"user_login" => $user->user_login,				 
				"user_email" => $user->user_email,
				"user_role"	 => $user->roles,
				"logged_in"	 => true
		);	
	 
		$response = array("success"=>true,'user'=>$user_->user_login,'userdata'=>$user_data);
		wp_send_json($response);
	} 
}
add_action('wp_ajax_popup_userlogin','popup_userlogin');
add_action('wp_ajax_nopriv_popup_userlogin','popup_userlogin');




//function to register new user
function popup_usersignup()
{
	global $wpdb;
	$userdata_['user_login'] = $_REQUEST['pdemail_'];
	$userdata_['user_email'] = $_REQUEST['pdemail_'];
	$userdata_['user_pass'] = $_REQUEST['pdpass_'];
	$userdata_['first_name'] = $_REQUEST['pdfname_'];
	$userdata_['last_name'] = $_REQUEST['pdlname_'];
	$userdata_['role']		= 'author';
	$userdata_['user_status'] = 2;
	
	
	
	
	
	$user_ =  get_user_by('email', $pd_email);
	if($user_)
	{
		
		$msg = "User with the email Id provided already exists";
		$response= array('success'=>false,'mmsg'=>$msg);
		wp_send_json($response);
	
	}
	else
	{	
		
		
		$user_id = wp_insert_user($userdata_);
		
		if(!is_numeric($user_id))
		{
			$msg = "Error occured while creating a new user. Please try again.";
			$success = false;
		}
		else
		{
			$msg = "Error occured while creating a new user. Please try again.";
			
			$response = array('success' => true,'user'=>$user_->user_login.$pd_pass );
			wp_send_json($response);
			$success = true;						
		}
		
		 

		 
		$response = array("success"=>true,'user'=>$user_->user_login,'userdata'=>$userdata_,'ret_userid'=>$user_id);
		wp_send_json($response);
	}//end else


}
add_action('wp_ajax_popup_usersignup','popup_usersignup');
add_action('wp_ajax_nopriv_popup_usersignup','popup_usersignup');

