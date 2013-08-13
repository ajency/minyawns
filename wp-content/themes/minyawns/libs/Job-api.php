<?php

/**
 * Minyawn_Job class
 * class WP_Post is declared as final and hence cannot be extended
 */
class Minyawn_Job {

    //JOB ID
    public $ID;
    // job owner. Name/ID/logo
    public $job_owner = array();
    //JOb details
    public $job_detials;
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
    public function __construct($ID) {

        if (!is_numeric((int) $ID))
            return false;

        //set class vars
        $this->ID = $ID;

        $this->query();
    }

    function query() {

        global $wpdb;

        $sql = $wpdb->prepare("	SELECT j.*,
        						GROUP_CONCAT(CONCAT(jm.meta_key,'|',jm.meta_value)) as meta
         						FROM {$wpdb->prefix}posts as j JOIN {$wpdb->prefix}postmeta as jm
							 	ON j.ID = jm.post_id 
							 	WHERE j.ID = %d 
							 	GROUP BY jm.post_id LIMIT 1", $this->ID);

        $job = $wpdb->get_row($sql);

        $this->job_details = $job->post_content;

        $this->posted_date = $job->post_date;


        $job_meta = get_post_meta($this->ID);
     
        $this->task = trim($job_meta['job_task'][0]);
        
        $this->job_start_date = trim($job_meta['job_start_date'][0]);
        
        $this->job_start_time = trim($job_meta['job_start_time'][0]);
        
        $this->job_end_time = trim($job_meta['job_end_time'][0]);
        
        $this->wages = trim($job_meta['job_wages'][0]);
        
        $this->location = trim($job_meta['job_location'][0]);
        
        $this->job_minyawns = trim($job_meta['job_required_minyawns'][0]);
        //convert the meta string to php array
       
    }

    public function is_active() {
        return $this->job_status == 'active';
    }

    public function is_pending() {
        return $this->job_status == 'pending';
    }

    public function is_locked() {
        return $this->job_status == 'locked';
    }

    public function is_completed() {
        return $this->job_status == 'complete';
    }

    public function get_job_status() {
        return $this->job_status;
    }

    public function get_applied_by() {
        return $this->applied_by;
    }



    public function get_job_posted_date() {
        global $minyawn_job;

        return date('d M Y', strtotime($this->posted_date));
    }

    public function get_job_date() {
        global $minyawn_job;

        return date('d M Y', $this->job_start_date);
    }
    
     public function get_job_required_minyawns() {
        global $minyawn_job;

        return $this->job_minyawns;
    }

     public function get_job_wages() {
        global $minyawn_job;

        return $this->wages;
    }
    public function get_job_details() {
        global $minyawn_job;
        return $this->job_details;
    }
    
    public function get_job_start_time() {
        global $minyawn_job;
        return date('H:i',$this->job_start_time);
    }
    
    public function get_job_end_time() {
        global $minyawn_job;

        return date('H:i',$this->job_end_time);
    }
    
    public function get_job_end_time_ampm() {
        global $minyawn_job;

        return date('a',$this->job_end_time);
    }
    
    public function get_job_start_time_ampm() {
        global $minyawn_job;

        return date('a',$this->job_start_time);
    }
    public function get_job_location() {
        global $minyawn_job;

        return $this->location;
    }
}


