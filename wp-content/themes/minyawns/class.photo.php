<?php

class PhotoModel{

/*public $photo_path;
public $photo_name;
public $photo_job_id;

public function __construct() {
  $this->photo_path = $_POST;
  $this->photo_name = $_FILES;
  $this->photo_name = $_FILES;
}*/


public function upload_photos(){

$file = $_FILES['photo']['tmp_name'];
$filename = $_FILES['photo']['name'];
$parent_post_id = $_POST['jobid'];
$user_id = $_POST['userid'];
 
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
	}

	return true;
}else{
	return false;
}


}











public function delete_photos($id){   
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



function user_can_upload( $jobid, $userid, $nonce ) {
 
	$is_valid_nonce = ( isset( $_POST[ $nonce ] ) && wp_verify_nonce( $_POST[ $nonce ], $userid ) );
	
	if($is_valid_nonce){
		return true;
	}else{
		return false;
	}
 
}




}

