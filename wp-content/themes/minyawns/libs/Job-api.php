<?php 


/**
 * Minyawn_Job class
 * class WP_Post is declared as final and hence cannot be extended
 */

class Minyawn_Job
{
	//JOB ID
	public $ID;

	// job owner. Name/ID/logo
	public $job_owner = array();

	//JOb details
	public $job_detials ;

	//job publish date
	public $posted_date = '0000-00-00 00:00:00';

	//actual job date
	public $job_start_date;

	//actual job date
	public $job_end_date;

	//job start time
	public $job_start_time; //24 hr format

	//job end time
	public $job_end_time; //24hr format

	//wages set for the job
	public $wages;

	//job tags
	public $tags;

	//required minyawns count for the job
	public $required_minyawns;

	//array of user appled for the job. array(user_id/profile name/ratelike/ratedislike/current-job-status/status-change-date)
	public $applied_by = array();

	//current job status
	public $job_status;

	public $include_meta = array('job_date',
								 'job_task',
								 'job_start_date',
								 'job_end_date',
								 'job_start_time',
								 'job_end_time',
								 'job_required_minyawns',
								 'job_wages',
								 'job_location');

	//constructor
	public function __construct( $ID ) {

		if(!is_numeric((int)$ID))
			return false;

		//set class vars
		$this->ID = $ID;

		$this->query();

	}	

	function query(){

		global $wpdb;

		$sql = $wpdb->prepare("	SELECT j.*,
        						GROUP_CONCAT(CONCAT(jm.meta_key,'|',jm.meta_value)) as meta
         						FROM {$wpdb->prefix}posts as j JOIN {$wpdb->prefix}postmeta as jm
							 	ON j.ID = jm.post_id 
							 	WHERE j.ID = %d 
							 	GROUP BY jm.post_id LIMIT 1", $this->ID);

		$job = $wpdb->get_row($sql);

		$this->job_detials = $job->post_content;

		$this->posted_date = $job->post_date;

		//convert the meta string to php array
    	$meta = explode(',',$job->meta);
    
    	foreach ($meta as $key => $value) {
    	   	$mt = explode('|',$value);
			if(in_array($mt[0],$this->include_meta))
				$this->key[$mt[0]] = $mt[1];
	    }

	}

	public function is_active()
	{
		return $this->job_status == 'active';
	}

	public function is_pending()
	{
		return $this->job_status == 'pending';
	}

	public function is_locked()
	{
		return $this->job_status == 'locked';
	}

	public function is_completed()
	{
		return $this->job_status == 'complete';
	}

	public function get_job_status()
	{
		return $this->job_status;
	}

	public function get_applied_by()
	{	
		return $this->applied_by;
	}
	
}


function get_job_details()
{
	global $minyawn_job;

	return $minyawn_job->job_detials;
}

function get_job_posted_date()
{
	global $minyawn_job;

	return date('d M Y',strtotime($minyawn_job->posted_date));
}

function get_job_date()
{
	global $minyawn_job;

	return date('d M Y',strtotime($minyawn_job->posted_date));
}