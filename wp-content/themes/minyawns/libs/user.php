<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array('debug' => true));

require '../../../../wp-load.php';

/** Update the profile data */
$app->post('/user', function() use ($app) {

	$requestBody = $app->request()->getBody();  // <- getBody() of http request
    $json_a = json_decode($requestBody, true);

	$user_id = $json_a['id'];

	//start updating profile data
	foreach($json_a as $key => $value) {
		if($key !== 'profileemail')
			update_user_meta($user_id, $key, $value);
	}

    $app->response()->header("Content-Type", "application/json");
    echo json_encode(array('success' => 1));

});

$app->run();