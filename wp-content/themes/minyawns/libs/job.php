<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';

/** Update the profile data */
$app->post('/addjob', function() use ($app) {

            $requestBody = $app->request()->getBody();  // <- getBody() of http request
            $json_a = json_decode($requestBody, true);

            $postid = ($json_a['id']) > 0 ? $json_a['id'] : '';

            $post = array(
                'ID' => $postid,
                'post_author' => "1", //The user ID number of the author.
                'post_date' => date("Y-m-d H:i:s"), //The time post was made.
                'post_date_gmt' => date("Y-m-d H:i:s"), //The time post was made, in GMT.
                'post_status' => 'publish',
                'post_title' => $json_a['job_task'],
                'post_type' => 'job',
                'post_content' => $json_a['job_details']
            );

            $post_id = wp_insert_post($post);



            foreach ($json_a as $key => $value) {

                if ($key == 'job_tags') {
                    $tags = explode(",", $value);

                    if(isset($postid))
                        wp_delete_object_term_relationships($postid, 'job_tags' );
                    
                    for ($i = 0; $i < count($tags); $i++) {
                        
                       
                        wp_set_post_terms($post_id, $tags[$i], 'job_tags', true);
                    
                        
                        
                        
                    }
                } elseif ($key == "job_start_date") {
                    update_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_start_time") {
                    update_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_end_date") {
                    update_post_meta($post_id, $key, strtotime($value));
                } elseif ($key == "job_end_time") {
                    update_post_meta($post_id, $key, strtotime($value));
                } elseif ($key !== 'job_details') {
                    update_post_meta($post_id, $key, $value);
                }
            }


            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('success' => 1));
        });



$app->post('/fetchjobs', function() use ($app) {
            global $post, $wpdb;

            $data = array();
            $querystr = "
                            SELECT $wpdb->posts.* 
                            FROM $wpdb->posts, $wpdb->postmeta
                            WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
                            AND $wpdb->postmeta.meta_key = 'job_start_date' 
                            AND $wpdb->postmeta.meta_value <= '" . current_time('timestamp') . "' 
                            AND $wpdb->posts.post_status = 'publish' 
                            AND $wpdb->posts.post_type = 'jobs'
                            ORDER BY $wpdb->posts.post_date DESC
                         ";

            $pageposts = $wpdb->get_results($querystr, OBJECT);

            foreach ($pageposts as $pagepost) {
                $post_meta = get_post_meta($pagepost->ID);
                $data = array(
                    'post_name' => $pagepost->post_title,
                    'post_date' => $pagepost->post_date,
                    'post_title' => $pagepost->post_title,
                    'post_id' => $pagepost->ID,
                    'job_start_date' => date('d M Y', $post_meta['job_start_date'][0]),
                    'job_end_date' => date('d M Y', $post_meta['job_end_date'][0]),
                   
                );
            }
            print_r($post_meta);
            exit();
            $app->response()->header("Content-Type", "application/json");
            echo json_encode(array('data' => $data, 'status' => "success"));
        });




$app->run();