<?php

global $wpdb;

/*
 * Function to check job completed 
 *  
 */

function job_completion_reminder() {

    $job_completion_sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}user_jobs,{$wpdb->prefix}posts,{$wpdb->prefix}postmeta
          WHERE {$wpdb->prefix}user_jobs.job_id={$wpdb->prefix}posts.ID AND {}
         
              ");
}


/**
 * Get all users who have signed up 3 days ago and still have not activated the account
 */
function users_notactivated_reminder()
{
	global $wpdb;
	$qr_user_not_logged = $wpdb->prepare("SELECT * 
											FROM {$wpdb->prefix}users 
											WHERE user_status = 2 
												and DATE(user_registered) = DATE_SUB(CURDATE( ), INTERVAL 3 DAY)  
										");
	//SELECT  * from  wp_users where DATE(user_registered)  = DATE_SUB( CURDATE( ), INTERVAL 3 DAY)
	
	$not_active_users = $wpdb->get_results($qr_user_not_logged);
	
	foreach($not_active_users as $not_active_user)
	{
		$emailid = $not_active_user->user_email;	
		
		$data['subject'] = "Hi ".$not_active_user->display_name; //temp
		$data['message'] = "Hi ".$not_active_user->display_name; //temp
		
		//activation link
		$data.="<br/><br/> <a href='".site_url()."/newuser-verification/?action=ver&key=".$not_active_user->user_activation_key."&email=" . $not_active_user->user_email . "'>" . site_url() . "/newuser-verification/?action=ver&key=".$not_active_user->user_activation_key."&email=".$not_active_user->user_email."</a>\r\n";
		
		/* generate email template in a variable */
		$mail = email_template($emailid, $data, 'user_activate_reminder');
		
		$email_content = $mail['hhtml'] . $mail['message'] . $mail['fhtml'];
		
		$email_subject = $mail['subject'];
		
		/* call function to make db insert */
		db_save_for_cron_job($emailid, $email_content, $email_subject, 'users_notactivated_reminder');
	}
	
}


/**
 * Get users who signed up & activated account and
 * havent applied for a job(role:minyawn) even after one week's time
 * or havent created a job(role:employer) even after one week's time
 */
function users_no_activity_reminder()
{
	global $wpdb;
	$qr_no_activity_users = $wpdb->prepare("SELECT a.*
										FROM {$wpdb->prefix}users a   
										NATURAL LEFT JOIN  {$wpdb->prefix}userjobs b
										WHERE b.user_id is null AND a.user_status = 0 AND DATE(a.user_registered) = DATE_SUB(CURDATE( ), INTERVAL 1 Week )  
										
										UNION
										
										SELECT c.*
										FROM {$wpdb->prefix}users c   
										NATURAL LEFT JOIN  {$wpdb->prefix}posts d
										WHERE (d.post_author is null or d.post_type!='job') AND c.user_status = 0 AND DATE(c.user_registered) = DATE_SUB(CURDATE( ), INTERVAL 1 Week )
										
										");
	$no_activity_users = $wpdb->get_results($qr_no_activity_users);
	foreach($no_activity_users as $no_activity_user)
	{
		
		$emailid = $no_activity_user->user_email;		
		 
		$user = new WP_User( $no_activity_user->ID );		
		if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
			foreach ( $user->roles as $role )
				$user_role = $role;		}
		
		
		switch($user_role)
		{
			case "minyawn":
							$data['subject'] = $no_activity_user->display_name. " Minion message: You havent applied for any job. ";
							$data['message'] = $no_activity_user->display_name. " Minion message: You havent applied for any job. ";								
							break;
			case "employer":
							$data['subject'] = $no_activity_user->display_name. " Minion message: You havent added any job. ";
							$data['message'] = $no_activity_user->display_name. " Employer message: There are no jobs added yet  ";
							break;
		}
		
		/* generate email template in a variable */
		$mail = email_template($emailid, $data, 'user_no_activity_reminder');
		
		$email_content = $mail['hhtml'] . $mail['message'] . $mail['fhtml'];
		
		$email_subject = $mail['subject'];
		
		/* call function to make db insert */
		db_save_for_cron_job($emailid, $email_content, $email_subject, 'users_no_activity_reminder');
	}
	
	
}


/*
 *  Gets all users profiles which are 
 *  incomplete @employer @minyawn using 'user_incomplete_profile_reminder' as mail type
 *  loads email template and save these entries in the cron_jobs table
 * 
 */

function user_incomplete_profile_reminder() {

    global $wpdb;
    $incomplete_profiles = $wpdb->get_results("(SELECT *
                                FROM my_users u1
                                INNER JOIN my_usermeta um1 ON u1.ID = um1.user_id
                                LEFT OUTER JOIN my_usermeta um2 ON u1.ID = um2.user_id
                                AND um2.meta_key = 'college'
                                WHERE um1.meta_key = 'my_capabilities'
                                AND um1.meta_value LIKE '%minyawn%'
                                AND um2.meta_key IS NULL
                                 AND u1.user_registered > DATE_SUB(NOW(), INTERVAL 24 HOUR)
                                )
                                UNION (

                                SELECT *
                                FROM my_users u1
                                INNER JOIN my_usermeta um1 ON u1.ID = um1.user_id
                                LEFT OUTER JOIN my_usermeta um2 ON u1.ID = um2.user_id
                                AND um2.meta_key = 'location'
                                WHERE um1.meta_key = 'my_capabilities'
                                AND um1.meta_value LIKE '%employer%'
                                AND um2.meta_key IS NULL
                                 AND u1.user_registered > DATE_SUB(NOW(), INTERVAL 24 HOUR)
                                )");

    /* generate usernames and emailds */
    foreach ($incomplete_profiles as $incomplete_profile) {


        $emailid = $incomplete_profile->user_email;

        $data = $incomplete_profile->display_name; //temp

        /* generate email template in a variable */
        $mail = email_template($emailid, $data, 'user_incomplete_profile_reminder');

        $email_content = $mail['hhtml'] . $mail['message'] . $mail['fhtml'];

        $email_subject = $mail['subject'];

        /* call function to make db insert */
        db_save_for_cron_job($emailid, $email_content, $email_subject, 'user_incomplete_profile_reminder');
    }
}
        

/*
 *  Function to save mails based on @type
 *  in cron_jobs table
 * 
 */

function db_save_for_cron_job($email, $content, $subject, $type) {
    global $wpdb;

    $existing_entry = "SELECT * from cron_jobs where email_recipient='" . $email . "' AND type='" . $type . "' AND flag='0'";

    $record_exists = $wpdb->get_row($existing_entry);

    if (count($record_exists) === 0) {
        $data = array(
            'email_recipient' => $email,
            'mail_content' => $content,
            'subject' => $subject,
            'type' => $type,
            'flag' => 0
        );

        $wpdb->insert('cron_jobs', $data);
    }
    //daily_cron(); /* call the cron function to exexute mails */
}

/*
 * 
 *  Job supposed to run on a  daily basis add appropriate 
 *  job_types in where clause
 * 
 */


function daily_cron() {
    global $wpdb;

    $daliy_crons_sql = $wpdb->get_results("SELECT * from cron_jobs WHERE flag='0'");

    foreach ($daliy_crons_sql as $daily_cron_sql) {

        $headers = 'From: Minyawns <support@minyawns.com>' . "\r\n";
        
        wp_mail($daily_cron_sql->email_recipient, $daily_cron_sql->subject, $daily_cron_sql->mail_content, $headers);
    }
}

?>
