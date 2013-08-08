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
function br_template_directory_uri($template_dir_uri, $template, $theme_root_uri) {
    return $theme_root_uri . '/minyawns';
}

add_filter('template_directory_uri', 'br_template_directory_uri', 100, 3);





//wp_localize_script( 'jquery-1.8.3.min', 'global', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ,'template_directory_uri' => get_template_directory_uri()  ) );


//function to log in user
function popup_userlogin()
{
	$pd_email = $_POST['pdemail'];
	$pd_pass = $_POST['pdpass'];
	
	$user_ =  get_user_by('email', $pd_email);
	$user  =  wp_authenticate($user_->user_login , $pd_pass);
	
	if (is_wp_error($user) )
	{
		$msg = "<div class='alert alert-error alert-box' style='padding: 10px 45px 10px 5px;font-size:12px'>  <button type='button' class='close' data-dismiss='alert'>&times;</button>Invalid email/password or verify your account with the verification link send to your email id. </div>";
		$response = array('success' => false,'user'=>$user_->user_login.$pd_pass,'msg'=>$msg );
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

add_action('wp_ajax_popup_userlogin', 'popup_userlogin');
add_action('wp_ajax_nopriv_popup_userlogin', 'popup_userlogin');


/*
 * Function to generate user activation key string
 *  
 */
function generate_user_activation_key($user_email)
{
	$salt = wp_generate_password(20); // 20 character "random" string
	$key = sha1($salt . $user_email . uniqid(time(), true));
	return($key);
}





//function to register new user
function popup_usersignup()
{
	global $wpdb;
	
	$user_activation_key = generate_user_activation_key($userdata_['user_email']);
	
	$userdata_['user_login'] = $_REQUEST['pdemail_'];
	$userdata_['user_email'] = $_REQUEST['pdemail_'];
	$userdata_['user_pass'] = $_REQUEST['pdpass_'];
	$userdata_['first_name'] = $_REQUEST['pdfname_'];
	$userdata_['last_name'] = $_REQUEST['pdlname_'];
	$userdata_['role']		= $_REQUEST['pdrole_'];
	$userdata_['user_status'] = 2;
	$userdata_['user_activation_key'] = $user_activation_key;
	
	
	
	
	$user_ =  get_user_by('email', $userdata_['user_email']);
	if($user_)
	{
		
		$msg = "<div class='alert alert-error alert-box'>  <button type='button' class='close' data-dismiss='alert'>&times;</button>User with the email Id provided already exists</div>";
		$response= array('success'=>false,'msg'=>$msg);
		wp_send_json($response);
		
		
	
	}
	else
	{	
		
		
		$user_id = wp_insert_user($userdata_);
		
		if(!is_numeric($user_id))
		{
			$msg = "Error occured while creating a new user. Please try again.";
			$success = false;
			$response = array("success"=>true,'msg'=>$msg);
			wp_send_json($response);
		}
		else
		{
			/*$msg = "Error occured while creating a new user. Please try again.";			
			$response = array('success' => true,'user'=>$user_->user_login.$pd_pass );
			wp_send_json($response);
			$success = true;	*/	
			$msg = "<div class='alert alert-success alert-box '>  <button type='button' class='close' data-dismiss='alert'>&times;</button>You have successfully registered. Please check your mail to complete registration</div>";
			 
			$wpdb->update($wpdb->users, array('user_activation_key' => $user_activation_key), array('user_login' => $userdata_['user_email']));
			$wpdb->update($wpdb->users, array('user_status' => 2), array('user_login' => $userdata_['user_email']));
			
			 
			$subject = "You have successfully registered on Minyaqns";
			$message="Hi, <br/><br/>You have successfully registered on <a href='".site_url()."' >Minyawns</a>.<br/><br/> To verify your account visit the following address";
			$message.=" <a href='".site_url()."/newuser-verification/?action=ver&key=".$user_activation_key."&email=". $userdata_['user_email'] . "'>".site_url()."/newuser-verification/?action=ver&key=".$user_activation_key."&email=". $userdata_['user_email']."</a>\r\n";
			//$message.= '<' . network_site_url("activate/?action=ver&key=$user_activation_key&email=" . $userdata_['user_email']) . ">\r\n";
			$message.="<br/><br/> Regards
					<br/>Minyawns Team<br/> ";
		 
			
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			wp_mail($userdata_['user_email'], $subject,email_header().$message.email_signature());
			
			
			
			$response = array("success"=>true,'msg'=>$msg,'user'=>$user_->user_login,'userdata'=>$userdata_,'ret_userid'=>$user_id);
			wp_send_json($response);
			
			
		}
		
		 

		 
		
	}//end else



	/*
	$user_ = get_user_by('email', $pd_email);
    if ($user_) {

        $msg = "User with the email Id provided already exists";
        $response = array('success' => false, 'mmsg' => $msg);
        wp_send_json($response);
    } else {


        $user_id = wp_insert_user($userdata_);

        if (!is_numeric($user_id)) {
            $msg = "Error occured while creating a new user. Please try again.";
            $success = false;
        } else {
            $msg = "Error occured while creating a new user. Please try again.";

            $response = array('success' => true, 'user' => $user_->user_login . $pd_pass);
            wp_send_json($response);
            $success = true;
        }




        $response = array("success" => true, 'user' => $user_->user_login, 'userdata' => $userdata_, 'ret_userid' => $user_id);
        wp_send_json($response);
    }//end else
    	
    */
}

add_action('wp_ajax_popup_usersignup', 'popup_usersignup');
add_action('wp_ajax_nopriv_popup_usersignup', 'popup_usersignup');




/**
 * Function to prevent dashboard access of users other than administrator
 */
 function minyawns_prevent_dashboard_access()
{
	//if ( false !== strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin' ) && !current_user_can( 'administrator' ) &&( false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/admin-ajax.php' ) &&  false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/async-upload.php' ) && false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/post.php' ) )  )
	//if ( false !== strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-login.php' ) && !current_user_can( 'administrator' ) &&( false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/admin-ajax.php' ) &&  false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/async-upload.php' ) && false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/post.php' ) )  )
	if(  (true!= strpos( strtolower( $_SERVER['REQUEST_URI'] ),'wp-admin')) &&  ( false !== strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-login.php' ) && !current_user_can( 'administrator' ) &&( false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/admin-ajax.php' ) &&  false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/async-upload.php' ) && false === strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/post.php' ) )  ) )
	wp_redirect( home_url() );
}


/**
 * Function to keep remeber me checked
 */
function minyawns_login_checked_remember_me() {
	add_filter( 'login_footer', 'rememberme_checked' );
}
//add_action( 'init', 'awm_login_checked_remember_me' );

function rememberme_checked() {
	echo "<script>document.getElementById('rememberme').checked = true;</script>";
}

function minyawns_initial_checks()
{
	//	awm_create_custom_tables();
	//awm_page_restrict();
	minyawns_prevent_dashboard_access();
	minyawns_login_checked_remember_me();
	//awm_do_download();
	//myStartSession();
}

add_action('init','minyawns_initial_checks'); 



//Allow only active users to login in 
add_filter('wp_authenticate_user', 'authenticate_active_user',10,2);
function authenticate_active_user ($user, $password) {
	//do any extra validation stuff here
	global $wpdb;
	
	$user_table = $wpdb->base_prefix.'users';
	//$res_verify_user =    $wpdb->get_results($wpdb->prepare("SELECT count(user_login) as user_count FROM wp_users WHERE user_login =%s AND user_status=0 ",$user),OBJECT);
	$res_verify_user = $wpdb->get_results( "SELECT count(user_login) as user_count FROM $user_table WHERE user_login ='".$user->user_login."' AND user_status=0 ",OBJECT );
	if($res_verify_user)
	{
		foreach($res_verify_user as $res_verify_usr)
		{	if($res_verify_usr->user_count>0)
		 		return $user;
		 
		}
	}
	else
		return false;
	
	
}

 




//added on 6aug2013 to add a custom role for the fb user, overrides plugin's default user role
add_filter('wpfb_inserting_user', 'fbautoconnect_insert_user',11,2);
function fbautoconnect_insert_user($user_data, $fbuser)
{
	global $_POST,$_REQUEST;
	
	//$user_data['role'] = 'minyawns';
	$user_data['role'] = $_POST['usr_role'];
	return($user_data);
}





/**
 * Class to run a code once
 */
if (!class_exists('run_once')){
	class run_once{
		function run($key){
			$test_case = get_option('run_once');
			if (isset($test_case[$key]) && $test_case[$key]){
				return false;
			}
			else{
				$test_case[$key] = true;
				update_option('run_once',$test_case);
				return true;
			}
		}

		function clear($key){
			$test_case = get_option('run_once');
			if (isset($test_case[$key])){
				unset($test_case[$key]);
			}
			update_option('run_once',$test_case);
		}
	}
}
 
//Function to remove all default roles except admin, and add roles employer & minyawns
function phoenix_add_role_cap_function()
{
	
	$run_once = new run_once();
	if ($run_once->run('remove_roles')){
		remove_role( 'editor' );
		remove_role( 'author' );
		remove_role( 'contributor' );
		remove_role( 'subscriber' );	
		
		
		/* Add minyawns role to the site */
		add_role('minyawn', 'minyawn', array(
		'read' => true,
		'edit_posts' => true,
		'delete_posts' => true,
		));
		
		/* Add employer role to the site */
		add_role('employer', 'employer', array(
		'read' => true,
		'edit_posts' => true,
		'delete_posts' => true,
		));
	}

}
add_action('init','phoenix_add_role_cap_function');




/**
 * generate mail header
 */
function email_header()
{

	return '<div style=" width:600px; margin:auto;background:url('.site_url().'/wp-content/themes/minyawns/images/pattern-bg.png);border: 5px solid #CCC;">
	<!-- header --->
	<div style="background-color: rgba(0, 0, 0, 0.39);padding: 6px;">
	<img src="'.site_url().'/wp-content/themes/minyawns/images/logo.png" />
	</div>
	<!--End of Header -->
	
	<!--Message -->

	<!--End Of Message -->

	<!--Footer -->
	<div style="margin-top:20px;">
		<div style="width:512px; margin:auto;">
			<div style=" font-size: 12px; line-height: 22px; ">';
}

/**
 * generate mail footer
 */
function email_signature()
{
	return '</div>			
			
				
		</div>
		<div style="clear:both;"></div>
		
		<div style="background:#f8f8f8;clear:both;margin:5px 5px 5px 5px;height:40px;padding-left: 10px;">
			<div style="float:left;"><h3 style="line-height:6px;">Find Us On</h3></div>
			<div style="float:right;margin-top: 5px;margin-right: 10px;"><a href="#"><img src="'.site_url().'/wp-content/themes/minyawns/images/Facebook.png" /></a></div>
			<div style="float:right;margin-top: 5px;margin-right: 10px;"><a href="#"><img src="'.site_url().'/wp-content/themes/minyawns/images/LinkedIn.png" /></a></div>
		</div>
		<br>
	
		<div style="background:url('.site_url().'/wp-content/themes/minyawns/images/arro-up.png)repeat-x;clear:both;margin:5px 5px 5px 5px;height:80px;padding-left: 10px;padding: 1px;">
		
			<h5 style="color:#ffffff;text-align:center;">Replies to this message are not monitored. Our Customer Service team is available to assist you here: </h5>
		</div>
	</div>
<!--End of footer -->
</div>';
}


//function to retrieve password on client side using ajax
function retrieve_password_ajx() {
	global $wpdb, $current_site;

	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) ) {
		//$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
		$msg = "Enter a username or e-mail address.";
		$success_val = false;
	} else if ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
		if ( empty( $user_data ) )
		{	//$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
			$msg = "There is no user registered with that email address.";
			$success_val = false;
		}
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}

	do_action('lostpassword_post');

	if ( $errors->get_error_code() )
	{
		//	return $errors;
		$success_val = false;
		$response = array('success' => $success_val,'msg'=>$msg );
		wp_send_json($response);
		
	}

	if ( !$user_data ) {
		//$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		$msg = "<div class='alert alert-success alert-box '>  <button type='button' class='close' data-dismiss='alert'>&times;</button>Invalid username or e-mail.</div>";
		$success_val = false;
		$response = array('success' => $success_val,'msg'=>$msg );
		wp_send_json($response);
		//return $errors;
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retreive_password', $user_login);  // Misspelled and deprecated
	do_action('retrieve_password', $user_login);

	$allow = apply_filters('allow_password_reset', true, $user_data->ID);

	if ( ! $allow )
	{
		//return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
		$success_val = false;
		$msg = 'Password reset is not allowed for this user';
		$response = array('success' => $success_val,'msg'=>$msg );
		wp_send_json($response);
		
	}
	else if ( is_wp_error($allow) )
		return $allow;

	$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
	if ( empty($key) ) {
		// Generate something random for a key...
		$key = wp_generate_password(20, false);
		do_action('retrieve_password_key', $user_login, $key);
		// Now insert the new md5 key into the db
		$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
	}
	$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
	$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
	//$message .= '<' . network_site_url("reset-password.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";
	$message .=" <a href='".site_url()."/change-password/?action=rp&key=".$key."&login=". rawurlencode($user_login). "'>".site_url()."/change-password/?action=ver&key=".$user_activation_key."&login=". rawurlencode($user_login) ."</a>\r\n";
	if ( is_multisite() )
		$blogname = $GLOBALS['current_site']->site_name;
	else
		// The blogname option is escaped with esc_html on the way into the database in sanitize_option
		// we want to reverse this for the plain text arena of emails.
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$title = sprintf( __('[%s] Password Reset'), $blogname );

	$title = apply_filters('retrieve_password_title', $title);
	$message = apply_filters('retrieve_password_message', $message, $key);
	
	add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
	
	if ( $message && !wp_mail($user_email, $title, email_header().$message.email_signature()) )
	{	
		$msg = '<div class="alert alert-success alert-box ">  <button type="button" class="close" data-dismiss="alert">&times;</button>The e-mail could not be sent.' . "<br />\n" . 'Possible reason: your host may have disabled the mail() function.</div>';
		$success_val = false;
	}
	else
	{	
		//wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.') );
		$msg = "<div class='alert alert-success alert-box '>  <button type='button' class='close' data-dismiss='alert'>&times;</button>Check your e-mail for the confirmation link.</div>";
		$success_val = true;
		

	}
	
	$response = array('success' => $success_val,'msg'=>$msg );
	wp_send_json($response);
	
	return true;
}
add_action('wp_ajax_retrieve_password_ajx', 'retrieve_password_ajx');
add_action('wp_ajax_nopriv_retrieve_password_ajx', 'retrieve_password_ajx');








/* Invalid new user verification key */
function invalid_newuserverification_key(){
	echo "
				<div class='container'>
					<div class='main-content '>
					<div class='alert alert-error ' style='width:70%;margin:auto;border: 10px solid rgba(204, 204, 204, 0.57);margin-top:10%;margin-bottom:10%'>
							<h4 style='text-align:center'>Invalid authentication key or email ID</h4>
							<hr>
							<img src='".get_template_directory_uri()."/images/big-minyawns.png'/ style='margin:auto;display:block;'>
							</div>
					</div>
				</div>

				";
}




/**
 * Retrieves a user row based on password reset key and login
 *
 * @uses $wpdb WordPress Database object
 *
 * @param string $key Hash to validate sending user's password
 * @param string $login The user login
 * @return object|WP_Error User's database row on success, error object for invalid keys
 */
function check_password_reset_key_($key, $login) {
	global $wpdb;

	$key = preg_replace('/[^a-z0-9]/i', '', $key);

	if ( empty( $key ) || !is_string( $key ) )
		return new WP_Error('invalid_key', __('Invalid key'));

	if ( empty($login) || !is_string($login) )
		return new WP_Error('invalid_key', __('Invalid key'));

	$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $login));

	if ( empty( $user ) )
		return new WP_Error('invalid_key', __('Invalid key'));

	return $user;
}

/**
 * Handles resetting the user's password.
 *
 * @param object $user The user
 * @param string $new_pass New password for the user in plaintext
 */
function reset_password_($user, $new_pass) {
	do_action('password_reset', $user, $new_pass);

	wp_set_password($new_pass, $user->ID);

	wp_password_change_notification($user);
}














 
add_filter( 'avatar_defaults', 'custom_avatar' );
 
function custom_avatar ($avatar_defaults) {
$myavatar = get_template_directory_uri() . '/images/profile.png';
$avatar_defaults[$myavatar] = "Branded Avatar";
return $avatar_defaults;
}
 






if ( !function_exists('fb_addgravatar') ) {
function fb_addgravatar( $avatar_defaults ) {
$myavatar = get_bloginfo('template_directory') . '/images/profile.png';
$avatar_defaults[$myavatar] = 'Users';
$myavatar2 = get_bloginfo('template_directory') . '/images/profile.png';
$avatar_defaults[$myavatar2] = 'My Avatar';
return $avatar_defaults; }
add_filter( 'avatar_defaults', 'fb_addgravatar' ); }

?>