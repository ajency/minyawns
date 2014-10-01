<?php

class PhotoModel{

public $user_id;
public $logged_in = false;
public $can_upload = false;
public $can_delete = false;
public $upload_nonce = false;
public $delete_nonce = false;
public $admin = false;


function init(){
    $this->user_id = get_current_user_id();

    if(is_super_admin()){
    	$this->admin = true;
    }

    if(is_user_logged_in()){
    	$this->logged_in = true;
    }
    if (current_user_can('upload_files') ) {
    	$this->can_upload = true;
    }
    if (current_user_can('delete_files') ) {
    	$this->can_delete = true;
    }
    if(isset( $_POST['upload_nonce'] ) && wp_verify_nonce( $_POST['upload_nonce'], $this->user_id )) {
    	$this->upload_nonce = true;
    }

  }

public function __construct() {
        //$this->user = get_current_user_id();
       }



public function upload_photos($jobid){

$file = $_FILES['photo']['tmp_name'];
$filename = $_FILES['photo']['name'];
//$parent_post_id = $_POST['jobid'];
$parent_post_id = $jobid;
$user_id = $this->user_id;

if(!$this->user_can_upload($parent_post_id)){
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
	$image_url =   wp_get_attachment_image_src($attachment_id, 'large' );
	$response = array(
		'status'	=> true,
		'photo'		=> array(
			'id'	=> $attachment_id,
			'url'	=> $image_url[0],
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











public function delete_photos($photoid){ 

if (!$this->user_can_delete($photoid)){
return false;
exit;
}

if(wp_delete_post($photoid)){
	return true;
}else{
	return false; 
}
}



public function get_photos($jobid='',$userid=''){
 
$args = array();
if($jobid !=''){
	$args["post_parent"] = $jobid;
}
if($userid !=''){
	$args["author"] = $userid;
	
}
$args['post_type'] = 'attachment';
$args['posts_per_page'] =  -1;
 
$results= get_posts( $args );

 
foreach($results as $result){

	$image_url =   wp_get_attachment_image_src($result->ID, 'large' );
 
   	$image_url = ( $image_url!=false)? $image_url[0]:'' ;
	 $data[] = array(
					'id' => $result->ID,
					'url' =>  $image_url,
					'author' => $result->post_author,
					'date' => $result->post_date,
					'job_id' => $result->post_parent

					);
}
	 
	return $data;
 
}





public function user_can_upload($jobid) {

if($this->admin){
	return true;
	exit;

//Check if is user logged in	
}else if (!$this->logged_in){
  return false;

 //Check for nonce
}else if(!$this->upload_nonce) {
return false;

//Check for user capabilities
}else if (!$this->can_upload) {
 return false;

//Check if job id was set
}else if($jobid>0){
//Check if user was hired for the job
if(!$this->is_user_hired_job($jobid)){
return false;
}else{
return true;
}
}else{

 return true;
}

}






public function user_can_delete($photoid) {
if($this->admin){
	return true;
	exit;

//Check if is user logged in	
}else if (!$this->logged_in){
  return false;

 //Check for nonce
}else if(!$this->delete_nonce) {
return false;

//Check for user capabilities
}else if (!$this->can_delete) {
 return false;

//Check if photo belongs to the user
}else if(!$this->is_user_has_photo($photoid)){
return false;
}else{
return true;
}
}




public function is_user_has_photo($photoid){
global $wpdb;
$userid = $this->user_id;
$query = "SELECT * FROM $wpdb->posts p where p.ID = $photoid AND where p.post_type = 'attachment' AND p.post_author = $userid AND (p.post_mime_type LIKE 'image/%')  AND (p.post_status = 'inherit')";
$results = $wpdb->get_row($query, ARRAY_A );
if(!$results){
return false;
}else{
 return true;
}
}




public function is_user_hired_job($jobid){

global $wpdb;
$userid = $this->user_id;
$results = $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."userjobs WHERE user_id = ".$userid." AND job_id = ".$jobid." AND status = 'hired'", ARRAY_A );
if(!$results){
return false;
}else{
 return true;
}

}




public function testcall(){
if ( $this->admin ) {
  echo "admin";
}

}




}

