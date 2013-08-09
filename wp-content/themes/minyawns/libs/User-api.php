<?php 
/**
 * Contains all required user api functions
 */ 


/**
 * Set up all existing profile data for the logged in user
 */
function setup_user_profile_data()
{
	if(!is_user_logged_in()) return;
	
	global $current_user;

	$user_meta = get_user_meta($current_user->data->ID);
	
	//set profile first name
	$current_user->data->first_name 	= $user_meta['first_name'][0];

	//set profile last name
	$current_user->data->last_name 		= $user_meta['last_name'][0];

	//set college
	$current_user->data->college 		= isset($user_meta['college']) ? $user_meta['college'][0] : '';

	//set major
	$current_user->data->major 			= isset($user_meta['major']) ? $user_meta['major'][0] : '';

	//set skills
	$current_user->data->user_skills	= isset($user_meta['user_skills']) ? maybe_unserialize($user_meta['user_skills'][0]) : array();

	//set socials
	$current_user->data->socials		= isset($user_meta['socials']) ? maybe_unserialize($user_meta['socials'][0]) : array();

	//set profile profile_body
	$current_user->data->profilebody	= isset($user_meta['profilebody']) ? $user_meta['profilebody'][0] : '';

	//set profile profile linked in
	$current_user->data->linkedin	= isset($user_meta['linkedin']) ? $user_meta['linkedin'][0] : '';
}
add_action('wp_loaded','setup_user_profile_data');

//User ID
function user_id()
{
	echo get_user_id();
}

function get_user_id()
{
	global $current_user;
	return $current_user->data->ID;
}

//user profile name
function user_profile_name()
{
	echo get_user_profile_name();
}

function get_user_profile_name()
{	
	global $current_user;

	return $current_user->data->first_name . ' ' . $current_user->data->last_name;
}

//User profile first name
function user_profile_first_name()
{
	echo get_user_profile_first_name();
}

function get_user_profile_first_name()
{	
	global $current_user;

	return $current_user->data->first_name;
}

//User profile last name
function user_profile_last_name()
{
	echo get_user_profile_last_name();
}

function get_user_profile_last_name()
{	
	global $current_user;

	return $current_user->data->last_name;
}

//User profile body
function user_profile_body()
{
	echo get_user_profile_body();
}

function get_user_profile_body()
{
	global $current_user;

	return $current_user->data->profilebody;
}

//User profile linkedin
function user_profile_linkedin()
{
	echo get_user_profile_linkedin();
}

function get_user_profile_linkedin()
{
	global $current_user;

	return $current_user->data->linkedin;;
}

// user role
function get_user_role(){
	global $current_user;
	
	return $current_user->roles[0];
}

//user college 
function user_college()
{
	echo get_user_college();
}

function get_user_college()
{
	global $current_user;
	return isset($current_user->data->college) ? $current_user->data->college : '';
}

// User college major
function user_college_major()
{
	echo get_user_college_major();
}

function get_user_college_major()
{
	global $current_user;
	return isset($current_user->data->major) ? $current_user->data->major : '';
}

//User profile email
function user_profile_email()
{
	echo get_user_profile_email();
}

function get_user_profile_email()
{
	global $current_user;
	return $current_user->data->user_email;
}

//User social pages
function get_user_social_pages()
{
	global $current_user;
	return isset($current_user->data->socials) ? $current_user->data->socials : array();
}

//User social pages
function get_user_skills()
{
	global $current_user;
	return isset($current_user->data->user_skills) ? $current_user->data->user_skills : array();
}

//User like count
function user_like_count()
{
	echo get_user_like_count();
}

function get_user_like_count()
{
	global $current_user;
	return isset($current_user->data->like_count) ? $current_user->data->like_count : 0;
}

//User dislike count
function user_dislike_count()
{
	echo get_user_dislike_count();
}

function get_user_dislike_count()
{
	global $current_user;
	return isset($current_user->data->like_count) ? $current_user->data->like_count : 0;
}
 