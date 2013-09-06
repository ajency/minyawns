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
    public $minyawns = array();
    //current job status
    public $job_status;
    //can apply
    public $can_apply;
    public $include_meta = array('job_date',
        'job_task',
        'job_start_date',
        'job_end_date',
        'job_start_time',
        'job_end_time',
        'job_required_minyawns',
        'job_wages',
        'job_location');
    public $include_user_meta = array('college', 'major', 'linkedin');

    //constructor
    public function __construct($ID) {

        if (!is_numeric((int) $ID))
            return false;

        //set class vars
        $this->ID = $ID;

        $this->query();

        $this->can_apply();
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

        $this->post_author=$job->post_author;
        
        $job_meta = get_post_meta($this->ID);

        $this->task = trim($job_meta['job_task'][0]);

        $this->job_start_date = trim($job_meta['job_start_date'][0]);

        $this->job_end_date = trim($job_meta['job_end_date'][0]);

        $this->job_start_time = trim($job_meta['job_start_time'][0]);

        $this->job_end_time = trim($job_meta['job_end_time'][0]);
        
       $this->job_end_date_time=trim($job_meta['job_end_date_time'][0]);
        
        //$this->user_skills = isset($job_meta['user_skills']) ? maybe_unserialize($job_meta['user_skills'][0]) : '';

        $this->wages = trim($job_meta['job_wages'][0]);

        $this->location = trim($job_meta['job_location'][0]);

        $this->required_minyawns = trim($job_meta['job_required_minyawns'][0]);

        $job_tags = wp_get_post_terms($this->ID, 'job_tags', array("fields" => "names"));

        $this->job_tags = ($job_tags) > 0 ? $job_tags : '';

        //get all users applied for the job
        $sql = $wpdb->prepare("SELECT {$wpdb->prefix}users.*, GROUP_CONCAT(CONCAT({$wpdb->prefix}usermeta.meta_key,'|',{$wpdb->prefix}usermeta.meta_value)) AS usermeta,{$wpdb->prefix}userjobs.*, SUM( if( rating =1, 1, 0 ) ) AS positive, SUM( if( rating = -1, 1, 0 ) ) AS negative
                              FROM {$wpdb->prefix}users
                              JOIN {$wpdb->prefix}usermeta ON user_id = {$wpdb->prefix}users.ID
                              JOIN {$wpdb->prefix}userjobs ON {$wpdb->prefix}userjobs.user_id = {$wpdb->prefix}users.ID
                              WHERE {$wpdb->prefix}userjobs.job_id = %d
                              GROUP BY {$wpdb->prefix}userjobs.user_id", $this->ID);

        
        $minyawns = $wpdb->get_results($sql);

        $this->applied_by = count($minyawns);

        if (!empty($minyawns)) {
            foreach ($minyawns as $minyawn) {

                $this->is_hired = $minyawn->status;
                $user = array(
                    'user_login' => $minyawn->user_login,
                    'profile_name' => $minyawn->display_name,
                    'user_email' => $minyawn->user_email,
                    'user_id' => $minyawn->ID,
                    'user_to_job' => $minyawn->job_id,
                    'user_job_status' => $minyawn->status,
                );
                  $user_meta=get_user_meta($minyawn->ID);
                $get_user_meta=$user_meta['user_skills'][0];
                    $user['user_skills']=$get_user_meta;
                




                //convert the meta string to php array
                $usermeta = explode(',', $minyawn->usermeta);
                $fb_uid = false;
                foreach ($usermeta as $meta) {

                    
                    $meta = explode('|', $meta);

                    if (in_array($meta[0], $this->include_user_meta))
                        $user[$meta[0]] = maybe_unserialize($meta[1]);

                    if ($meta[0] == 'avatar_attachment')
                        $user['image'] = wp_get_attachment_thumb_url($meta[1]);

                    if ($meta[0] == 'facebook_uid')
                        $fb_uid = $meta[1];
                    
                    
                        
                }
                
                //set image
                if (!isset($user['image']) && $fb_uid !== false)
                    $user['image'] = 'https://graph.facebook.com/' . $fb_uid . '/picture?width=200&height=200';
                elseif (!isset($user['image']))
                    $user['image'] = false;
//                if (!isset($user['rate_like']))
//                    $user['rate_like'] = 0;
//                if (!isset($user['rate_dislike']))
//                    $user['rate_dislike'] = 0;

                $sql = $wpdb->prepare("SELECT {$wpdb->prefix}userjobs.user_id,{$wpdb->prefix}userjobs.job_id, SUM( if( rating =1, 1, 0 ) ) AS positive, SUM( if( rating = -1, 1, 0 ) ) AS negative
                              FROM {$wpdb->prefix}userjobs
                              WHERE {$wpdb->prefix}userjobs.user_id = %d AND {$wpdb->prefix}userjobs.job_id =%d
                              GROUP BY {$wpdb->prefix}userjobs.user_id", $minyawn->ID,$minyawn->job_id);

                $minyawns_rating = $wpdb->get_results($sql);

                foreach ($minyawns_rating as $rating) {
                    $user['like'] = $rating->positive;
                    $user['dislike'] = $rating->negative;
                    
                    if($user['like'] != "0" || $user['dislike'] != "0")
                        $user['is_job_rated']=1;
                    
                    else
                        $user['is_job_rated']=0;
                }
                
                $user['is_job_owner']=  is_job_owner($minyawn->ID, $minyawn->job_id);

                $this->minyawns[$minyawn->ID] = $user;
            }
           
        }
       
        // global $post;

        $tables = "$wpdb->posts,{$wpdb->prefix}userjobs";
        $my_jobs_filter = "WHERE $wpdb->posts.ID = {$wpdb->prefix}userjobs.job_id AND {$wpdb->prefix}userjobs.job_id =$this->ID";


        $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $tables
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            ORDER BY $wpdb->posts.ID DESC
                            
                         ";

        $data = array();
        $pageposts = $wpdb->get_results($querystr, OBJECT);
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

        return $this->required_minyawns;
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
        return date('g:i', $this->job_start_time);
    }

    public function get_job_end_time() {
        global $minyawn_job;

        return date('g:i', $this->job_end_time);
    }

    public function get_job_end_date() {
        global $minyawn_job;
        return date('d M Y', $this->job_end_date);
    }

    public function get_job_end_date_time()
    {
        global $minyawn_job;
        return $this->job_end_date_time;
    }
    
    public function get_current_date_time()
    {
        
        return current_time('timestamp');
        
    }
    
    
    public function get_job_end_time_ampm() {
        global $minyawn_job;

        return date('a', $this->job_end_time);
    }

    public function get_job_start_time_ampm() {
        global $minyawn_job;

        return date('a', $this->job_start_time);
    }

    public function get_job_location() {
        global $minyawn_job;

        return $this->location;
    }

    public function get_job_applied_minyawns() {
        return count($this->minyawns);
    }

    //can user apply
    public function can_apply() {

        $this->can_apply = 0;

        //check if requirement is complete
        if (count($min_job->minyawns) > 0) {
            if ((int) ($min_job->required_minyawns) + 2 <= count($min_job->minyawns))
                $this->can_apply = 1;
        }else {
            $this->can_apply = 0;
        }

        if ($this->can_apply === 0 && array_key_exists(get_user_id(), $this->minyawns))
            $this->can_apply = 2;


        if (!is_null($this->is_hired)) {
            if ($this->is_hired == 'applied')
                $this->can_apply = 2;
            else
                $this->can_apply = 3;
        }
    }

    public function get_job_id() {
        global $minyawn_job;
        return $this->ID;
    }

    public function get_start_time_eform() {
        global $minyawn_job;

        return date('H:i a ', $this->job_start_time);
    }

    public function get_end_time_eform() {
        global $minyawn_job;

        return date('H:i a ', $this->job_end_time);
    }

    public function get_job_tags() {

        return implode(',', $this->job_tags);
    }

    function check_minyawn_job_status($jobID) {
         global $wpdb;
        $my_jobs_filter = "WHERE $wpdb->posts.ID = {$wpdb->prefix}userjobs.job_id  AND  {$wpdb->prefix}userjobs.job_id='{$jobID}' AND  {$wpdb->prefix}userjobs.user_id='" . get_user_id() . "'";

        $querystr = "
                            SELECT $wpdb->posts.*,{$wpdb->prefix}userjobs.*
                            FROM $wpdb->posts,{$wpdb->prefix}userjobs
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            ORDER BY $wpdb->posts.ID DESC
                               ";
       
        $user_applied_to = $wpdb->get_results($querystr, OBJECT);

        if (count($user_applied_to) > 0) {
            foreach ($user_applied_to as $applied) {
                if ($applied->status == "hired")
                    $applied = 3;

                if ($applied->status == "applied")
                    $applied = 1;
            }
        }

        $min_job = new Minyawn_Job($jobID);
         if ((int) ($min_job->required_minyawns) + 2 <= count($min_job->minyawns)) 
                        $applied = 2;



        return $applied;
    }

}

function get_total_jobs() {
    global $wpdb;
    $tables = "$wpdb->posts, $wpdb->postmeta";
    $my_jobs_filter = "WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            AND $wpdb->postmeta.meta_value >= '" . current_time('timestamp') . "'";


    $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $tables
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            
                         ";

    return count($wpdb->get_results($querystr));
}

function is_job_owner($user_id, $job_id) {
    global $wpdb;

    if (get_user_role() != 'minyawn') {
        $tables = "$wpdb->posts";
        $my_jobs_filter = "WHERE $wpdb->posts.post_author = '" . $user_id . "' AND $wpdb->posts.ID='" . $job_id . "'";

        $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $tables
                            $my_jobs_filter
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'job'
                            
                         ";

        $is_author = $wpdb->get_results($querystr, OBJECT);

        if (count($is_author) > 0)
            return 1;
        else
            return 0;
    }
    else
        return false;
}

function get_user_rating($user_id, $job_id) {
    
    
    
}

