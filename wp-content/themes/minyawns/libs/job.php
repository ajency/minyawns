<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';

/** Update the profile data */
$app->post('/addjob', function() use ($app) {

            $requestBody = $app->request()->getBody();  // <- getBody() of http request
            $json_a = json_decode($requestBody, true);
//print_r($json_a);exit();
            $post = array(
                'post_author' => "1", //The user ID number of the author.
                'post_date' => date("Y-m-d H:i:s"), //The time post was made.
                'post_date_gmt' => date("Y-m-d H:i:s"), //The time post was made, in GMT.
                'post_name' => $json_a['job_task'], // The name (slug) for your post
                'post_status' => 'publish',
                'post_title' => $json_a['job_task'],
                'post_type' => 'jobs',
                'post_content' => $json_a['job_details']
            );

            $post_id = wp_insert_post($post);

            

            foreach ($json_a as $key => $value) {

                if ($key == 'jobtags') {
                    $tags = explode(",", $tags);
                    for ($i = 0; $i < sizeof($tags); $i++) {
                        wp_insert_term($tags[$i], 'job_tags');
                    }
                } elseif ($key == "job_start_date") {
                    add_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_start_time") {
                    add_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_end_time") {
                    add_post_meta($post_id, $key, strtotime($value));
                } elseif ($key !== 'job_details') {
                    add_post_meta($post_id, $key, $value);
                }
            }


            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('success' => 1));
        });

$app->post('/fetchjobs', function() use ($app) {
            global $post, $wpdb;

            $querystr = "
    SELECT $wpdb->posts.* 
    FROM $wpdb->posts, $wpdb->postmeta
    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
    AND $wpdb->postmeta.meta_key = 'start-date' 
    AND $wpdb->postmeta.meta_value > '" . current_time('timestamp') . "' 
    AND $wpdb->posts.post_status = 'publish' 
    AND $wpdb->posts.post_type = 'jobs'
    ORDER BY $wpdb->posts.post_date DESC
 ";

            $pageposts = $wpdb->get_results($querystr, OBJECT);
            print_r($querystr);
            exit();
        });




$app->run();