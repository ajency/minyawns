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
	$current_user->data->first_name 	= trim($user_meta['first_name'][0]);

	//set profile last name
	$current_user->data->last_name 		= trim($user_meta['last_name'][0]);

	//set college
	$current_user->data->college 		= isset($user_meta['college']) ? trim($user_meta['college'][0]) : '';

	//set major
	$current_user->data->major 			= isset($user_meta['major']) ? trim($user_meta['major'][0]) : '';

	//set skills
	$current_user->data->user_skills	= isset($user_meta['user_skills']) ? maybe_unserialize($user_meta['user_skills'][0]) : array();

	//set socials
	$current_user->data->socials		= isset($user_meta['socials']) ? maybe_unserialize($user_meta['socials'][0]) : array();

	//set profile profile_body
	$current_user->data->profilebody	= isset($user_meta['profilebody']) ? trim($user_meta['profilebody'][0]) : '';

	//set profile profile linked in
	$current_user->data->linkedin		= isset($user_meta['linkedin']) ? trim($user_meta['linkedin'][0]) : '';

	//set profile profile linked in
	$current_user->data->company_website= isset($user_meta['company_website']) ? trim($user_meta['company_website'][0]) : '';

	//set profile profile linked in
	$current_user->data->location		= isset($user_meta['location']) ? trim($user_meta['location'][0]) : '';

	//set profile facebook_uid
	$current_user->data->facebook_uid	= isset($user_meta['facebook_uid']) ? trim($user_meta['facebook_uid'][0]) : 0;

	//set profile facebook_avatar_full image
	$current_user->data->facebook_avatar_full	= isset($user_meta['facebook_avatar_full']) ? trim($user_meta['facebook_avatar_full'][0]) : '';

	//set profile facebook_avatar_thumb image
	$current_user->data->facebook_avatar_thumb	= isset($user_meta['facebook_avatar_thumb']) ? trim($user_meta['facebook_avatar_thumb'][0]) : '';
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

//is fb registered
function is_user_fb_registered()
{
	global $current_user;
	return $current_user->data->facebook_uid !== 0;
}

//get user FB avatar URL
function get_user_fb_avatar($type = 'thumb')
{
	global $current_user;
	return $type == 'large' ? $current_user->data->facebook_avatar_full : $current_user->data->facebook_avatar_thumb;
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

//Company website
function user_company_website()
{
	echo get_user_company_website();
}
function get_user_company_website()
{
	global $current_user;
	return $current_user->data->company_website;
}

//User location
function user_location()
{
	echo get_user_location();
}
function get_user_location()
{
	global $current_user;
	return $current_user->data->location;
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

/**
 * CLass to get all user's jobs
 */
class MN_User_Jobs {

    var $query_vars = array();
    var $jobs;
    var $job;
    var $job_count = 0;
    var $current_job = -1;
    var $in_the_loop = false;

    function __construct($args = null) {
        if (!empty($args)) {

        	if(!isset($args['user_id'])) return;

            $this->query_vars = wp_parse_args($args, array(
                'user_id'=> false,
                'status' => false
            ));

            $this->query();
        }
    }

    function query() {
        global $wpdb;

        $qv = & $this->query_vars;

        $and = '';
        
        if (false !== $qv['status'])
            $and = $wpdb->prepare("AND ub.status=%s", $qv['status']);

        $sql = $wpdb->prepare("	SELECT ub.status, ub.rating,
        						GROUP_CONCAT(CONCAT(jm.meta_key,'|',jm.meta_value)) as meta
         						FROM {$wpdb->prefix}userjobs as ub JOIN {$wpdb->prefix}postmeta as jm
							 	ON ub.job_id = jm.post_id 
							 	WHERE ub.user_id = %d 
							 	$and 
							 	GROUP BY jm.post_id", $qv['user_id']);
 		
        $this->jobs = $wpdb->get_results($sql);
        
        $this->job_count = count($this->jobs);

        if($this->job_count > 0)
        {	
        	$include_meta = array('job_logo','startdatetime','enddatetime','wages');

        	//convert the meta string to php array
        	foreach ($this->jobs as &$value) {
	       		$meta = explode(',',$value->meta);
	       		
				$parsedmeta = array();
				foreach ($meta as $m) {
					$mt = explode('|',$m);

					if(in_array($m[0],$include_meta))
						$parsedmeta[$mt[0]] = $mt[1];
				}
				$value->meta = $parsedmeta;
	        }
	     }
    }

    function have_jobs() {
        if ($this->current_job + 1 < $this->job_count) {
            return true;
        } elseif ($this->current_job + 1 == $this->job_count && $this->job_count > 0) {
            //do_action_ref_array('loop_end', array(&$this));
            // Do some cleaning up after the loop
            $this->rewind_jobs();
        }

        $this->in_the_loop = false;
        return false;
    }

    function rewind_jobs() {
        $this->current_job = -1;
        if ($this->job_count > 0) {
            $this->job = $this->jobs[0];
        }
    }

    function the_job() {
        global $mn_job;
        $this->in_the_loop = true;

        if ($this->current_job == -1) // loop has just started
            do_action_ref_array('loop_start', array(&$this));

        $mn_job = $this->next_job();
    }

    function next_job() {

        $this->current_job++;

        $this->job = $this->jobs[$this->current_job];
        return $this->job;
    }

}