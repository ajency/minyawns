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

//update the user avatar
$app->post('/change-avatar', function() use($app) {
	
	global $user_ID;

	$targetFolder = '/uploads/user-avatars/' . $user_ID; // Relative to the root


	$files = $_FILES['files'];


	if ($files['name'])
	{
		$file = array(
				'name' 	=> $files['name'],
				'type' 	=> $files['type'],
				'tmp_name' => $files['tmp_name'],
				'error' => $files['error'],
				'size' 	=> $files['size']
		);

		$_FILES = array("upload_attachment" => $file);



		$attach_data = array();


		foreach ($_FILES as $file => $array)
		{
			$attach_id 		= upload_attachment($file,$user_ID);
			$attachment_id	= $attach_id;
			$attachment_url = wp_get_attachment_thumb_url($attach_id);

		}
	}
});

$app->run();



function upload_attachment($file_handler,$user_id)
{

	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK)
		__return_false();

	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');

	//add filter

	function change_user_avatar_upload_dir( $pathdata ) {
	  	
	  	global $user_ID;
	  	$pathdata['path'] 	= $pathdata['basedir'] . '/user-avatars/' . $user_ID;
	  	$pathdata['subdir'] = '/user-avatars/' . $user_ID;
	  	$pathdata['url']	= $pathdata['baseurl'] . '/user-avatars/' . $user_ID; 

	    return $pathdata;
	}

	add_filter('upload_dir', 'change_user_avatar_upload_dir');

	$attach_id = media_handle_upload( $file_handler, 0 );

	remove_filter('upload_dir', 'change_user_avatar_upload_dir');

	update_user_meta($user_id,'avatar_attachment',$attach_id);
	return $attach_id;
}