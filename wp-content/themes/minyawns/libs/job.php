<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';

/** Update the profile data */
$app->post('/addjob', function() use ($app) {

	$requestBody = $app->request()->getBody();  // <- getBody() of http request
    $json_a = json_decode($requestBody, true);

    $post = array(
                'ID' => '', //Are you updating an existing post?
               'post_author' => "1", //The user ID number of the author.
                'post_date' => date("Y-m-d H:i:s"), //The time post was made.
                'post_date_gmt' => date("Y-m-d H:i:s"), //The time post was made, in GMT.
                'post_name' =>$json_a['tasks'], // The name (slug) for your post
                'post_status' => 'publish',
                'post_title' => $json_a['tasks'],
                'post_type' => 'jobs'
            
                );
               $post_id= wp_insert_post($post);
            
            
            foreach($json_a as $key=>$value)
            {
                
                add_post_meta($post_id, $key, $value);
            }
            
	
    $app->response()->header("Content-Type", "application/json");
    echo json_encode(array('success' => 1));

});

$app->run();