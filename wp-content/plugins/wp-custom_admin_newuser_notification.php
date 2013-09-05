<?php
/**
 * @package Custom New User Notification
 * @version 1.6
 */
/*
Plugin Name: Custom New User Notification
Description: Replaces default user registration mail notification  

*/
if ( !function_exists('wp_new_user_notification') ) :
function wp_new_user_notification($user_id, $plaintext_pass = '') {
	$user = get_userdata( $user_id );

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n<br/>";
	$message .= sprintf(__('Username: %s'), $user->user_login) . "\r\n\r\n<br/>";
	$message .= sprintf(__('E-mail: %s'), $user->user_email) . "\r\n<br/>";

	//@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);

	add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
	$headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
	wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), email_header() . $message . email_signature(), $headers);
	
	
	
	if ( empty($plaintext_pass) )
		return;
/*
	$message  = sprintf(__('testUsername: %s'), $user->user_login) . "\r\n";
	$message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n";
	$message .= wp_login_url() . "\r\n";

	wp_mail($user->user_email, sprintf(__('[%s] Your username and password'), $blogname), $message);*/

}
endif;
?>
