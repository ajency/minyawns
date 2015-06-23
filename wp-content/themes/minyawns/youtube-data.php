<?php
require_once('../../../wp-blog-header.php');

//Add Video
if($_GET['action'] == 'add'){


  function introVideoDuration($videoid) {
    $apikey = "AIzaSyD_5TrelzezQlHp_-wgfkhP_s7HoMemO6A" ;
    $dur = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=$videoid&key=$apikey");
    $VidDuration =json_decode($dur, true);
    foreach ($VidDuration['items'] as $vidTime) 
    {
      $VidDuration = $vidTime['contentDetails']['duration'];
    }
    $date = new DateTime('2000-01-01');
    $date->add(new DateInterval($VidDuration));
    $hms = $date->format('H:i:s') ;
    $seconds = strtotime("1970-01-01 ".$hms." UTC");
    return $seconds;
  }


if (wp_verify_nonce($_GET['nonce'], 'addvideotousermeta')){

    if(introVideoDuration($_GET['videoid'])>30){
      $response = "Maximum video duration 30 seconds exceeded.";  
  }else{
      if(update_user_meta($_GET['userid'], 'intro_video_id', $_GET['videoid'])){
        $response = "ok"; 
    }else{
        $response = "Unable to assign video to user profile";
    }  
}

}else{
    $response = "Invalid API call";
}
echo $response;

}




//Delete Video
if($_GET['action'] == 'delete'){

    if (wp_verify_nonce($_GET['nonce'], 'deletevideousermeta')){
        if ( ! delete_user_meta($_GET['userid'], 'intro_video_id') ) {
          $response = 'There was some problem deleting intro video.';
      }else{
        $response = 'ok';
    }


}else{
    $response = 'Invalid API Call';
}

echo $response;

}




?>