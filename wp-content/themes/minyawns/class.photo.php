<?php

class PhotoModel{


public function upload_photos($jobid){

$file = $_FILES['photo']['tmp_name'];
$filename = $_FILES['photo']['name'];
//$parent_post_id = $_POST['jobid'];
$parent_post_id = $jobid;
$user_id = $_POST['userid'];

if(!$this->user_can_upload($parent_post_id,$user_id)){
	return array(
		'status'	=> false,
		'error'		=> 'User not authorised to perform this task.',
		);
	exit;
}

 
$upload_file = wp_upload_bits($filename, null, file_get_contents($file));

if (!$upload_file['error']) {
	$wp_upload_dir = wp_upload_dir();
	$wp_filetype = wp_check_filetype($filename, null );
	$attachment = array(
		'guid'           => $wp_upload_dir['url'] . '/' . $filename,
		'post_mime_type' => $wp_filetype['type'],
		'post_parent' => $parent_post_id,
		'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
		'post_content' => '',
		'post_author' => $user_id,
		'post_status' => 'inherit'
	);
	$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
	if (!is_wp_error($attachment_id)) {
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
		wp_update_attachment_metadata( $attachment_id,  $attachment_data );
	}else{
		$response = array(
		'status'	=> false,
		'error'		=> is_wp_error($attachment_id)
		);
	}

	$response = array(
		'status'	=> true,
		'photo'		=> array(
			'id'	=> $attachment_id,
			'url'	=> $wp_upload_dir['url'] . '/' . $filename,
			'author' => $user_id,
			'date' => get_the_date('Y-m-d H:i:s.u',$attachment_id),
			'job_id' => $parent_post_id
			)
		);

}else{
	
	$response = array(
		'status'	=> false,
		'error'		=> $upload_file['error']
		);
}

return $response;
}











public function delete_photos($id){ 

/*if (!$this->user_can_delete('$id','$userid')){
return false;
exit;
}*/

if(wp_delete_post($id)){
	return true;
}else{
	return false; 
}
}



public function get_photos($jobid='',$userid=''){

	global $wpdb;

		
	if($jobid !='' && $userid !=''){
	$query = "SELECT * FROM $wpdb->posts p where p.post_type = 'attachment' AND p.post_author = $userid AND p.post_parent = $jobid AND (p.post_mime_type LIKE 'image/%')  AND (p.post_status = 'inherit') ORDER BY p.post_date DESC";
	}

	if($userid =='' && $jobid !=''){
	$query = "SELECT * FROM $wpdb->posts p where p.post_type = 'attachment' AND p.post_parent = $jobid AND (p.post_mime_type LIKE 'image/%')  AND (p.post_status = 'inherit') ORDER BY p.post_date DESC";
	}

	if($jobid =='' && $userid !=''){
	$query = "SELECT * FROM $wpdb->posts p where p.post_type = 'attachment' AND p.post_author = $userid AND (p.post_mime_type LIKE 'image/%')  AND (p.post_status = 'inherit') ORDER BY p.post_date DESC";
	}

	
	$results =  $wpdb->get_results( $query );

	if ( $results ) {
		$data = array();
		foreach ( (array) $results as $image ) {

			if($this->photo_exists($image->guid)){
				$data[] = array(
					'id' => $image->ID,
					'url' => $image->guid,
					'author' => $image->post_author,
					'date' => $image->post_date,
					'job_id' => $image->post_parent

					);
			}
		}
	}

	return $data;

}


/*To check whether the image exist or not.*/
public function photo_exists($url){
$path = parse_url($url, PHP_URL_PATH);
$full_path = $_SERVER['DOCUMENT_ROOT'] . $path;
if(file_exists($full_path)){
	return true;
}else{
	return false;
}
}



public function user_can_upload($jobid,$userid) {

//Check if is user logged in
/*if (!is_user_logged_in()){
  return false;

 //Check for nonce
}else if(! isset( $_POST['upload_nonce'] ) || ! wp_verify_nonce( $_POST['upload_nonce'], 'secretstring' )) {
return false;

//Check for user capabilities
}else if ( !current_user_can('upload_files') ) {
 return false;

//Check if job id was set
}else */if($jobid>0){
//Check if user was hired for the job
if(!$this->is_user_hired_job($jobid,$userid)){
return false;
}else{
return true;
}
}else{

 return true;
}

}






public function user_can_delete($photoid,$userid) {
if(!$this->is_user_has_photo($photoid,$userid)){
return false;
}else{
return true;
}
}




public function is_user_has_photo($photoid,$userid){
global $wpdb;
$query = "SELECT * FROM $wpdb->posts p where p.ID = $photoid AND where p.post_type = 'attachment' AND p.post_author = $userid AND (p.post_mime_type LIKE 'image/%')  AND (p.post_status = 'inherit')";
$results = $wpdb->get_row($query, ARRAY_A );
if(!$results){
return false;
}else{
 return true;
}
}




public function is_user_hired_job($jobid,$userid){

global $wpdb;
$results = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."userjobs WHERE user_id = ".$userid." AND job_id = ".$jobid." AND status = 'hired'", ARRAY_A );
if(!$results){
return false;
}else{
 return true;
}

}




}

