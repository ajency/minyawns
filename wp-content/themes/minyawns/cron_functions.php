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
